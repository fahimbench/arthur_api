<?php

namespace App\Services;

use App\Entity\NikoNikoDataResult;
use App\Entity\NikoNikoGroup;
use App\Entity\NikoNikoUser;
use App\Exception\UserExistInAnyGroupException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class NikoNikoService
{
    private  $em;
    private $requestStack;

    /**
     * NikoNikoService constructor.
     * @param EntityManagerInterface $em
     * @param RequestStack $requestStack
     */
    public function __construct(EntityManagerInterface $em, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    /**
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getDataGroup(){
        $group = $this->requestStack->getMasterRequest()->get('group');
        $dateStart = $this->requestStack->getMasterRequest()->get('dateStart');
        $dateEnd = $this->requestStack->getMasterRequest()->get('dateEnd');

        if(!ctype_digit(strval($group))){
            $group = 1;
        }

        try{
            if(!$dateStart){
                $dateStart = (new \DateTime('first day of this month'));
            }else{
                $dateStart = (new \DateTime($dateStart));
            }

            if(!$dateEnd){
                $dateEnd = (new \DateTime('last day of this month'));
            }else{
                $dateEnd = (new \DateTime($dateEnd));
            }

            if($dateStart > $dateEnd){
                return ['ok' => false, 'message' => "Vous ne pouvez pas chercher avec une date de début commençant après la fin"];
            }

        }catch(\Exception $e){
            return ['ok' => false, 'message', 'message' => 'Une ou plusieurs dates nécessaire au graphique sont incorrecte'];
        }

        $text = $this->em->getRepository(NikoNikoGroup::class)->findOneBy([
            'id' => $group
        ])->getName();

        $labels = [];
        $data = [];
        $scoreNull = [];
        $scoreBlank = [];
        $participants = [];

        if($dateStart->format('D') != 'Mon'){
            $dateStart->modify('next monday');
        }
        do {
            $score = $this->scoreDate($group, $dateStart->format('Y-m-d'));
            $labels[] = $dateStart->format('Y-m-d');
            $data[] = $score['scorePercent'];
            $scoreNull[] = $score['scoreNull'] ?: 0;
            $scoreBlank[] = $score['scoreBlank'] ?: 0;
            $participants[] = $score['participants'] ?: 0;
            $dateStart->modify('next monday');
        }while($dateStart <= $dateEnd);

        $return = ['ok' => true, 'data' => [
            'labels' => $labels,
            'text' => $text,
            'data' => $data,
            'participants' => $participants,
            'abstention' => $scoreNull,
            'blank' => $scoreBlank
        ]];

        return $return;
    }

    /**
     * Verifie si tout est valide et créer les apprenants ainsi que le groupe
     * appelle knowIfNameIsValid
     * appelle knowIfUsersAlreadyInGroupAndValid
     *
     * @return mixed
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function createGroupAndUserIfValid(){
        $name = $this->requestStack->getMasterRequest()->get('name');
        $users = $this->requestStack->getMasterRequest()->get('users');
        $dateStart = $this->requestStack->getMasterRequest()->get('dateStart');
        $dateEnd = $this->requestStack->getMasterRequest()->get('dateEnd');
        $dateIgnore = $this->requestStack->getMasterRequest()->get('dateIgnore');

        if($name){
            $valide = $this->NameIsValid($name);
            if(!$valide['ok']){
                return $valide;
            }
        }else{
            return ['ok' => false, 'message' => "Vous devez avoir un nom pour le groupe"];
        }

        if($users){
            $valide = $this->UsersAlreadyInGroupAndValid($users);
            if(!$valide['ok']){
                return $valide;
            }
        }else{
            return ['ok' => false, 'message' => "Vous n'ajoutez aucun utilisateur au groupe"];
        }

        if($dateStart && $dateEnd){
            $valide = $this->AllDateValid($dateStart, $dateEnd, $dateIgnore);
            if(!$valide['ok']){
                return $valide;
            }
        }else{
            return ['ok' => false, 'message' => "Il faut obligatoirement une date de début début et une de fin pour le groupe"];
        }

        try {
            $ds = (new \DateTime($dateStart))->format("Y-m-d");
            $group = (new NikoNikoGroup())
                ->setName($name)
                ->setDateStart(\DateTime::createFromFormat("Y-m-d", (new \DateTime($dateStart))->format("Y-m-d")))
                ->setDateEnd(\DateTime::createFromFormat("Y-m-d", (new \DateTime($dateEnd))->format("Y-m-d")));
            $ignoreFormat = [];
            foreach ($dateIgnore as $ignore) {
                $ignore = json_decode($ignore);
                $ignoreFormat[] = [
                    "dateStart" => (new \DateTime($ignore->dateStart))->format("Y-m-d"),
                    "dateEnd" => (new \DateTime($ignore->dateEnd))->format("Y-m-d")
                ];
            }
            $group->setDateIgnore($ignoreFormat);
            $this->em->persist($group);

            foreach ($users as $user) {
                $u = (new NikoNikoUser())
                    ->setIdSlack(json_decode($user)->id)
                    ->setNikoNikoGroups($group);

                $this->em->persist($u);
            }
            $this->em->flush();
        }catch(\Exception $e){
            return ['ok' => false, 'message' => $e];
        }
        return ['ok' => true];
    }

    /**
     * Verifie si un utilisateur est Valide
     * taille caractere de l'id = 9
     * appelle testUserExist
     * @param mixed $users
     * @return false|array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    private function UsersAlreadyInGroupAndValid($users){
        if($users){
            foreach ($users as $user){
                $user = json_decode($user);
                if(strlen($user->id) !== 9){
                    return ['ok' => false, 'message' => "L'id d'un user doit comporter 9 caractères"];
                }
                $dbuser = $this->em->getRepository(NikoNikoUser::class)->findBy([
                    'idSlack' => $user->id
                ]);
                if($dbuser){
                    return ['ok' => false, 'message' => "Au moins un des apprenants est déjà dans un groupe"];
                }
                if(!$this->testUserExist($user->id)){
                    return ['ok' => false, 'message' => "Un des apprenant est inexistant sur Slack"];
                }
            }
        }
        return ['ok' => true];
    }

    /**
     * Test si l'utilisateur est existant sur le Workspace du Slack
     * @param string $user
     * @return bool
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    private function testUserExist(string $user){
        $httpClient = HttpClient::create([
            'auth_bearer' => $_ENV['TOKEN_API_SLACK']
        ]);
        try{
            $response = $httpClient->request('GET', 'https://slack.com/api/users.info', [
                'query' => ['user' => $user]
            ]);
            if(json_decode($response->getContent())->ok === false){
                echo $response->getContent();
                return false;
            }
            return true;
        }catch(\Exception $e){
            echo $e;
            return false;
        }
    }

    /**
     * Determine si le nom du groupe est valide
     * chaine >= 10
     * comporte les caracteres du Regex
     * @param string $name
     * @return array
     */
    private function NameIsValid(string $name){
        if(strlen($name) < 10){
            return ['ok' => false, 'message' => "Le nom du groupe est trop petit (10 caractères minimum)"];
        }
        if(!preg_match("/^[a-zA-Z0-9àâçéèêëîïôûùüÿñæœ'\/\\\ %&²$*#~:;=+()°?!,<>[\]_.-]*$/", $name)){
            return ['ok' => false, 'message' => "Le nom du groupe n'est pas valide, un ou plusieurs caractères ne sont pas acceptés"];
        }
        return ['ok' => true];
    }

    /**
     * Compare toute les dates
     * Compare start et end
     * Compare les dates ignores
     * @param $dateStart
     * @param $dateEnd
     * @param $dateIgnore
     * @return array
     */
    private function AllDateValid($dateStart, $dateEnd, $dateIgnore){
        try{
            $dateStart = new \DateTime($dateStart);
            $dateEnd = new \DateTime($dateEnd);

            if($dateStart > $dateEnd){
                return ['ok' => false, 'message' => "Vous ne pouvez pas commencer après la date de fin de la formation"];
            }

            if($dateIgnore){
                foreach ($dateIgnore as $ignore){
                    $ignore = json_decode($ignore);
                    $dateStartIgnore = new \DateTime($ignore->dateStart);
                    $dateEndIgnore = new \DateTime($ignore->dateEnd);

                    if($dateStartIgnore > $dateEndIgnore){
                        return ['ok' => false, 'message' => "Vous ne pouvez pas ignorer une date commençant après sa fin"];
                    }

                    if($dateStartIgnore <= $dateStart || $dateEndIgnore >= $dateEnd){
                        return ['ok' => false, 'message' => "Une date ignorée sort du début ou de la fin de la formation"];
                    }

                    $compareIgnore =
                        array_filter($dateIgnore, function($n) use ($dateStartIgnore, $dateEndIgnore){
                            $n = json_decode($n);
                            $nDateStart = new \DateTime($n->dateStart);
                            $nDateEnd = new \DateTime($n->dateEnd);

                            return ($dateStartIgnore != $nDateStart && $dateStartIgnore != $nDateEnd &&
                                    (($dateStartIgnore >= $nDateStart && $dateStartIgnore <= $nDateEnd) ||
                                    ($dateEndIgnore >= $nDateStart && $dateEndIgnore <= $nDateEnd) ||
                                    ($dateStartIgnore <= $nDateStart && $dateEndIgnore >= $nDateEnd)));
                        });

                    if(!empty($compareIgnore)){
                        return ['ok' => false, 'message' => "Une ou plusieurs date ignorées se chevauchent"];
                    }
                }
            }
        }catch(\Exception $e){
            return ['ok' => false, 'message' => "Une ou plusieurs des dates ne sont pas valide"];
        }
        return ['ok' => true];
    }

    /**
     * @param $group
     * @param $date
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function scoreDate($group, $date){
        $scoreRepo = $this->em->getRepository(NikoNikoDataResult::class);
        $scoreNormal = $scoreRepo->findDataWithDate($group, $date)['score'];
        $scoreNull = $scoreRepo->findNullDataWithDate($group, $date);
        $scoreBlank = $scoreRepo->findMinusOneDataWithDate($group, $date);
        $users = $this->em->getRepository(NikoNikoUser::class)->findAndCountUserInGroup($group)['count'];

        if($scoreNormal && $users) {
            return [
                'scorePercent' => ceil(($scoreNormal / ($users * 4)) * 100),
                'scoreNull' =>  count($scoreNull),
                'scoreBlank' =>  count($scoreBlank),
                'participants' => $users - (count($scoreNull) + count($scoreBlank))
            ];
        }else{
            return [
                'scorePercent' => null,
                'scoreNull' => null,
                'scoreBlank' => null,
                'participants' => null
            ];
        }
    }
}
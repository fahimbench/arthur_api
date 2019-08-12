<?php
namespace App\Controller;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
class AuthController extends AbstractController
{
    /**
     * @Route("/token_tester", name="token_tester", methods={"POST"})
     * @param JWTEncoderInterface $jwtencoder
     * @param Request $request
     * @return JsonResponse
     */
    public function testToken(JWTEncoderInterface $jwtencoder, Request $request){
        try{
            $token = $request->get('token');
            $jwtencoder->decode($token);
        }catch(JWTDecodeFailureException $e){
            return $this->json(["ok"=>false]);
        }
        return $this->json(["ok"=>true]);
    }

    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $em = $this->getDoctrine()->getManager();
        
        $username = $request->request->get('_username');
        $password = $request->request->get('_password');
        
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($encoder->encodePassword($user, $password));
        $em->persist($user);
        $em->flush();
        return new Response(sprintf('User %s successfully created', $user->getUsername()));
    }

    public function api()
    {
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }
}
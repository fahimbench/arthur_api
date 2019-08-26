<?php
namespace App\Controller;

use App\Exception\ErrorActionCallException;
use App\Services\QuestionService;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class QuestionOperation
{
    private $ladderService;
    private $requestStack;

    /**
     * LadderController constructor.
     * @param QuestionService $ladderService
     * @param RequestStack $requestStack
     */
    public function __construct(QuestionService $ladderService, RequestStack $requestStack)
    {
        $this->ladderService = $ladderService;
        $this->requestStack = $requestStack;
    }

    /**
     * @Route(name="ladderAction",path="/question_ladders/action",methods="GET")
     * @param $data
     * @return mixed
     * @throws ErrorActionCallException
     */
    public function __invoke($data)
    {
        $call = $this->requestStack->getMasterRequest()->get('call');

        if(method_exists($this->ladderService, $call)){
            return $this->ladderService->$call();
        }else{
            throw new ErrorActionCallException('message');
        }
    }
}
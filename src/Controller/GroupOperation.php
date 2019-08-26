<?php

namespace App\Controller;

use App\Services\NikoNikoService;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\HttpException;
use \Symfony\Component\Routing\Annotation\Route;
use App\Exception\ErrorActionCallException;

class GroupOperation
{
    private $nikonikoService;
    private $requestStack;

    /**
     * LadderController constructor.
     * @param NikoNikoService $nikonikoService
     * @param RequestStack $requestStack
     */
    public function __construct(NikoNikoService $nikonikoService, RequestStack $requestStack)
    {
        $this->nikonikoService = $nikonikoService;
        $this->requestStack = $requestStack;
    }

    /**
     * Appelle la méthode décrite dans la variable call
     * @Route(name="groupAction",path="/niko_niko_groups/action",methods={"GET"})
     * @return mixed
     * @throws HttpException
     */
    public function __invoke()
    {
        $call = $this->requestStack->getMasterRequest()->get('call');

        if(method_exists($this->nikonikoService, $call)){
            $response = $this->nikonikoService->$call();
//            if(isset($response->headers) && $response->headers->get('Content-Type') === 'text/csv'){
//                return $response;
//            }
            if(!$response['ok']){
                throw new HttpException(400, $response['message']);
            }
            return json_encode($response);
        }else{
            throw new HttpException(400,"Action inexistante.");
        }
    }
}
<?php

namespace Validator;

use \Util\ConstantesGenericasUtil;
use \Util\jsonUtil;
use Repository\tokensAutorizadosRepository;
use Service\UsuariosService;

class RequestValidator
{
    private $request;
    private array $dadosRequest = [];
    private object $tokensAutorizadosRepository;

    const GET = 'GET';
    const DELETE = 'DELETE';
    const USUARIOS = 'USUARIOS';

    public function __construct($request)
    {
        $this->request = $request;
        $this->tokensAutorizadosRepository = new tokensAutorizadosRepository();
    }

    public function processarRequest()
    {
        $retorno = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);

        if(in_array($this->request['metodo'], ConstantesGenericasUtil::TIPO_REQUEST, true)){
            $retorno = $this->direcionarRequest();
        }

        return $retorno;
    }

    private function direcionarRequest()
    {
        if($this->request['metodo'] !== self::GET && $this->request['metodo'] !== self::DELETE){
            $this->dadosRequest = jsonUtil::tratarCorpoRequisicaoJson();
        }
        $this->tokensAutorizadosRepository->validarToken(getallheaders()['Authorization']);
        $metodo = $this->request['metodo'];

        //função/metodo variavel (manual php)
        // o mesmo que $this->get() ou $this->delete() ou post ou put
        return $this->$metodo();
    }

    private function get()
    {
        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;
        if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_GET, true)){
            switch ($this->request['rota']) {
                case self::USUARIOS:
                    $UsuariosService = new UsuariosService($this->request);
                    $retorno = $UsuariosService->validarGet();
                    break;
                default:
                    throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
        }
        return $retorno;
    }

    private function delete()
    {
        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;
        if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_DELETE, true)){
            switch ($this->request['rota']) {
                case self::USUARIOS:
                    $UsuariosService = new UsuariosService($this->request);
                    $retorno = $UsuariosService->validarDelete();
                    break;
                default:
                    throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
        }
        return $retorno;
    }

    private function post()
    {
        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;
        if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_POST, true)){
            switch ($this->request['rota']) {
                case self::USUARIOS:
                    $UsuariosService = new UsuariosService($this->request);
                    $UsuariosService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $UsuariosService->validarPost();
                    break;
                default:
                    throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
        }
        return $retorno;
    }

    private function put()
    {
        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;
        if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_PUT, true)){
            switch ($this->request['rota']) {
                case self::USUARIOS:
                    $UsuariosService = new UsuariosService($this->request);
                    $UsuariosService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $UsuariosService->validarPut();
                    break;
                default:
                    throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
        }
        return $retorno;
    }
}
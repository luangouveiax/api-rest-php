<?php

require_once('bootstrap.php');

use Validator\RequestValidator;
use Util\RotasUtil;
use Util\ConstantesGenericasUtil;
use \Util\jsonUtil;

try {
    $RequestValidator = new RequestValidator(RotasUtil::getRotas());
    $retorno = $RequestValidator->processarRequest();

    $jsonUtil = new jsonUtil();
    $jsonUtil->processarArrayParaRetornar($retorno);

} catch (\Exception $e) {
    echo json_encode([
        ConstantesGenericasUtil::TIPO => ConstantesGenericasUtil::TIPO_ERRO,
        ConstantesGenericasUtil::RESPOSTA => $e->getMessage()
    ]);
    exit();
}
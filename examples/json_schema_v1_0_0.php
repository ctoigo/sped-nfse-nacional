<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use JsonSchema\Constraints\Constraint;
use JsonSchema\Constraints\Factory;
use JsonSchema\SchemaStorage;
use JsonSchema\Validator;

$version = '1_0_0';

$jsonSchema = '{
    "title": "RPS",
    "type": "object",
    "properties": {
        "IdentificacaoRps": {
            "required": true,
            "type": "object",
            "properties": {
                "Numero": {
                    "required": true,
                    "type": "integer",
                    "pattern": "^[0-9]{1,15}"
                },
                "Serie": {
                    "required": true,
                    "type": "string",
                    "maxLength": 5
                },
                "Tipo": {
                    "required": true,
                    "type": "integer",
                    "pattern": "^[1-3]{1}"
                }
            }
        },
        "DataEmissao": {
            "required": true,
            "type": "string",
            "pattern": "^([0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])T(2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9])$"
        },
        "NaturezaOperacao": {
            "required": true,
            "type": "integer",
            "pattern": "^[1-6]{1}"
        },
        "RegimeEspecialTributacao": {
            "required": true,
            "type": "integer",
            "pattern": "^[1-6]{1}"
        },
        "OptanteSimplesNacional": {
            "required": true,
            "type": "integer",
            "pattern": "^[1-2]{1}"
        },
        "IncentivoCultural": {
            "required": true,
            "type": "integer",
            "pattern": "^[1-2]{1}"
        },
        "Status": {
            "required": true,
            "type": "integer",
            "pattern": "^[1-2]{1}"
        },
        "Prestador": {
            "required": true,
            "type": "object",
            "properties": {
                "Cnpj": {
                    "required": true,
                    "type": "string",
                    "maxLength": 14
                },
                "InscricaoMunicipal": {
                    "required": true,
                    "type": "string",
                    "maxLength": 14
                }
            }
        },
        "Tomador": {
            "required": true,
            "type": "object",
            "properties": {
                "Cnpj": {
                    "required": false,
                    "type": ["string","null"],
                    "maxLength": 14
                },
                "Cpf": {
                    "required": false,
                    "type": ["string","null"],
                    "maxLength": 11
                },
                "InscricaoMunicipal": {
                    "required": false,
                    "type": ["string","null"],
                    "maxLength": 14
                },
                "RazaoSocial": {
                    "required": true,
                    "type": "string"
                },
                "Endereco": {
                    "required": false,
                    "type": ["object","null"],
                    "properties": {
                        "Endereco": {
                            "required": true,
                            "type": "string"
                        },
                        "Numero": {
                            "required": true,
                            "type": "string"
                        },
                        "Complemento": {
                            "required": true,
                            "type": "string"
                        },
                        "Bairro": {
                            "required": true,
                            "type": "string"
                        },
                        "CodigoMunicipio": {
                            "required": true,
                            "type": "integer",
                            "pattern": "^[0-9]{7}"
                        },
                        "Uf": {
                            "required": true,
                            "type": "string",
                            "maxLength": 2
                        },
                        "Cep": {
                            "required": true,
                            "type": "integer",
                            "pattern": "^[0-9]{8}"
                        }
                    }
                }
            }
        },    
        "Servico": {
            "required": true,
            "type": "object",
            "properties": {
                "ItemListaServico": {
                    "required": true,
                    "type": "string"
                },
                "CodigoTributacaoMunicipio": {
                    "required": true,
                    "type": "string"
                },
                "Discriminacao": {
                    "required": true,
                    "type": "string"
                },
                "CodigoMunicipio": {
                    "required": true,
                    "type": "integer",
                    "pattern": "^[0-9]{7}"
                },
                "Valores": {
                    "required": true,
                    "type": "object",
                    "properties": {
                        "ValorServicos": {
                            "required": true,
                            "type": "number"
                        },
                        "ValorDeducoes": {
                            "required": false,
                            "type": ["number", "null"]
                        },
                        "ValorPis": {
                            "required": false,
                            "type": ["number", "null"]
                        },
                        "ValorCofins": {
                            "required": false,
                            "type": ["number", "null"]
                        },
                        "ValorInss": {
                            "required": false,
                            "type": ["number", "null"]
                        },
                        "ValorIr": {
                            "required": false,
                            "type": ["number", "null"]
                        },
                        "ValorCsll": {
                            "required": false,
                            "type": ["number", "null"]
                        },
                        "IssRetido": {
                            "required": true,
                            "type": "integer",
                            "pattern": "^[1-2]{1}"
                        },
                        "ValorIss": {
                            "required": false,
                            "type": ["number", "null"]
                        },
                        "OutrasRetencoes": {
                            "required": false,
                            "type": ["number", "null"]
                        },
                        "Aliquota": {
                            "required": true,
                            "type": "number"
                        },
                        "DescontoIncondicionado": {
                            "required": false,
                            "type": ["number", "null"]
                        },
                        "DescontoCondicionado": {
                            "required": false,
                            "type": ["number", "null"]
                        }
                    }
                }
            }
        },
        "IntermediarioServico": {
            "required": false,
            "type": ["object","null"],
            "properties": {
                "RazaoSocial": {
                    "required": true,
                    "type": "string"
                },
                "Cnpj": {
                    "required": false,
                    "type": ["string","null"],
                    "maxLength": 14
                },
                "Cpf": {
                    "required": false,
                    "type": ["string","null"],
                    "maxLength": 11
                },
                "InscricaoMunicipal": {
                    "required": false,
                    "type": ["string","null"],
                    "maxLength": 14
                }
            }
        },
        "ConstrucaoCivil": {
            "required": false,
            "type": ["object","null"],
            "properties": {
                "CodigoObra": {
                    "required": true,
                    "type": "string"
                },
                "Art": {
                    "required": true,
                    "type": "string"
                }
            }
        }
    }
}';


$std = new \stdClass();
$std->IdentificacaoRps = new \stdClass();
$std->IdentificacaoRps->Numero = 11; //limite 15 digitos
$std->IdentificacaoRps->Serie = '1'; //BH deve ser string numerico
$std->IdentificacaoRps->Tipo = 1; //1 - RPS 2 - Nota Fiscal Conjugada (Mista) 3 - Cupom
$std->DataEmissao = '2018-10-31T12:33:22';
$std->NaturezaOperacao = 1; // 1 – Tributação no município
                            // 2 - Tributação fora do município
                            // 3 - Isenção
                            // 4 - Imune
                            // 5 –Exigibilidade suspensa por decisão judicial
                            // 6 – Exigibilidade suspensa por procedimento administrativo

$std->RegimeEspecialTributacao = 1;    // 1 – Microempresa municipal
                                        // 2 - Estimativa
                                        // 3 – Sociedade de profissionais
                                        // 4 – Cooperativa
                                        // 5 – MEI – Simples Nacional
                                        // 6 – ME EPP – Simples Nacional

$std->OptanteSimplesNacional = 1; //1 - SIM 2 - Não
$std->IncentivoCultural = 2; //1 - SIM 2 - Não
$std->Status = 1;  // 1 – Normal  2 – Cancelado

$std->Prestador = new \stdClass();
$std->Prestador->Cnpj = '99999999000191';
$std->Prestador->InscricaoMunicipal = '1733160024';

$std->Tomador = new \stdClass();
$std->Tomador->Cnpj = "99999999000191";
$std->Tomador->Cpf = "12345678901";
$std->Tomador->RazaoSocial = "Fulano de Tal";

$std->Tomador->Endereco = new \stdClass();
$std->Tomador->Endereco->Endereco = 'Rua das Rosas';
$std->Tomador->Endereco->Numero = '111';
$std->Tomador->Endereco->Complemento = 'Sobre Loja';
$std->Tomador->Endereco->Bairro = 'Centro';
$std->Tomador->Endereco->CodigoMunicipio = 3106200;
$std->Tomador->Endereco->Uf = 'MG';
$std->Tomador->Endereco->Cep = 30160010;

$std->Servico = new \stdClass();
$std->Servico->ItemListaServico = '11.01';
$std->Servico->CodigoTributacaoMunicipio = '522310000';
$std->Servico->Discriminacao = 'Teste de RPS';
$std->Servico->CodigoMunicipio = 3106200;

$std->Servico->Valores = new \stdClass();
$std->Servico->Valores->ValorServicos = 100.00;
$std->Servico->Valores->ValorDeducoes = 10.00;
$std->Servico->Valores->ValorPis = 10.00;
$std->Servico->Valores->ValorCofins = 10.00;
$std->Servico->Valores->ValorInss = 10.00;
$std->Servico->Valores->ValorIr = 10.00;
$std->Servico->Valores->ValorCsll = 10.00;
$std->Servico->Valores->IssRetido = 1;
$std->Servico->Valores->ValorIss = 10.00;
$std->Servico->Valores->OutrasRetencoes = 10.00;
$std->Servico->Valores->Aliquota = 5;
$std->Servico->Valores->DescontoIncondicionado = 10.00;
$std->Servico->Valores->DescontoCondicionado = 10.00;

$std->IntermediarioServico = new \stdClass();
$std->IntermediarioServico->RazaoSocial = 'INSCRICAO DE TESTE SIATU - D AGUA -PAULINO S'; 
$std->IntermediarioServico->Cnpj = '99999999000191';
$std->IntermediarioServico->InscricaoMunicipal = '8041700010';

$std->ConstrucaoCivil = new \stdClass();
$std->ConstrucaoCivil->CodigoObra = '1234';
$std->ConstrucaoCivil->Art = '1234';

// Schema must be decoded before it can be used for validation
$jsonSchemaObject = json_decode($jsonSchema);
if (empty($jsonSchemaObject)) {
    echo "<h2>Erro de digitação no schema ! Revise</h2>";
    echo "<pre>";
    print_r($jsonSchema);
    echo "</pre>";
    die();
}
// The SchemaStorage can resolve references, loading additional schemas from file as needed, etc.
$schemaStorage = new SchemaStorage();
// This does two things:
// 1) Mutates $jsonSchemaObject to normalize the references (to file://mySchema#/definitions/integerData, etc)
// 2) Tells $schemaStorage that references to file://mySchema... should be resolved by looking in $jsonSchemaObject
$schemaStorage->addSchema('file://mySchema', $jsonSchemaObject);
// Provide $schemaStorage to the Validator so that references can be resolved during validation
$jsonValidator = new Validator(new Factory($schemaStorage));
// Do validation (use isValid() and getErrors() to check the result)
$jsonValidator->validate(
    $std,
    $jsonSchemaObject,
    Constraint::CHECK_MODE_COERCE_TYPES  //tenta converter o dado no tipo indicado no schema
);

if ($jsonValidator->isValid()) {
    echo "The supplied JSON validates against the schema.<br/>";
} else {
    echo "JSON does not validate. Violations:<br/>";
    foreach ($jsonValidator->getErrors() as $error) {
        echo sprintf("[%s] %s<br/>", $error['property'], $error['message']);
    }
    die;
}
//salva se sucesso
file_put_contents("../storage/jsonSchemes/v$version/rps.schema", $jsonSchema);
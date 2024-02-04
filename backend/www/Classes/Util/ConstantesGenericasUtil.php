<?php

namespace Util;

abstract class ConstantesGenericasUtil
{
    /* REQUESTS */
    public const TIPO_REQUEST           = ['GET', 'POST', 'DELETE', 'PUT'];
    public const TIPO_GET               = ['USUARIOS', 'FORMAS_PAGAMENTO', 'PRODUTOS', 'CLIENTES', 'VENDAS'];
    public const TIPO_POST              = ['USUARIOS', 'FORMAS_PAGAMENTO', 'PRODUTOS', 'CLIENTES', 'VENDAS'];
    public const TIPO_DELETE            = ['USUARIOS', 'FORMAS_PAGAMENTO', 'PRODUTOS', 'CLIENTES'];
    public const TIPO_PUT               = ['USUARIOS', 'FORMAS_PAGAMENTO', 'PRODUTOS', 'CLIENTES'];

    /* ERROS */
    public const MSG_ERRO_TIPO_ROTA             = 'Rota não permitida!';
    public const MSG_ERRO_RECURSO_INEXISTENTE   = 'Recurso inexistente!';
    public const MSG_ERRO_GENERICO              = 'Algum erro ocorreu na requisição!';
    public const MSG_ERRO_SEM_RETORNO           = 'Nenhum registro encontrado!';
    public const MSG_ERRO_NAO_AFETADO           = 'Nenhum registro afetado!';
    public const MSG_ERRO_TOKEN_VAZIO           = 'É necessário informar um Token!';
    public const MSG_ERRO_TOKEN_NAO_AUTORIZADO  = 'Token não autorizado!';
    public const MSG_ERR0_JSON_VAZIO            = 'O Corpo da requisição não pode ser vazio!';

    /* SUCESSO */
    public const MSG_DELETADO_SUCESSO       = 'Registro deletado com sucesso!';
    public const MSG_ATUALIZADO_SUCESSO     = 'Registro atualizado com sucesso!';
    public const MSG_INSERIDO_SUCESSO       = 'Registro inserido com sucesso!';
    public const MSG_LOGIN_SUCESSO          = 'Login realizado com sucesso!';
    public const MSG_TOKEN_OK               = 'Token autorizado!';
    public const MSG_LOGOUT                 = 'Usuário deslogado!';

    /* RECURSO USUARIOS */
    public const MSG_ERRO_ID_OBRIGATORIO            = 'ID é obrigatório!';
    public const MSG_ERRO_LOGIN_EXISTENTE           = 'Login já existente!';
    public const MSG_ERRO_LOGIN_SENHA_OBRIGATORIO   = 'Login e senha são obrigatórios!';

    /* RETORNO JSON */
    const TIPO_SUCESSO  = 'sucesso';
    const TIPO_ERRO     = 'erro';

    /* OUTRAS */
    public const SIM        = 'S';
    public const TIPO       = 'tipo';
    public const RESPOSTA   = 'resposta';
}
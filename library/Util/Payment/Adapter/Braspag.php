<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Braspag.php 20/06/2012 16:31:59 leonardo $
 */

/**
 * @see Util_Payment_Adapter_Abstract
 */
require_once 'Util/Payment/Adapter/Abstract.php';

/**
 * Comunicação com gateway de pagamento Braspag.
 *
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Payment_Adapter_Braspag extends Util_Payment_Adapter_Abstract
{
	/**
	 * Configura o adapter.
	 * @see library/Util/Payment/Adapter/Util_Payment_Adapter_Abstract::init()
	 */
	public function init()
	{
		
		
		
	}
	
	/**
	 * Efetua uma autorização de crédito na operadora.
	 *
	 * A Autorização verifica se o cartão de crédito usado é válido,
	 * se o portador possui limite suficiente e se a transação passou
	 * na verificação de fraude do banco e da operadora.
	 *
	 * Esta é a fase mais importante da transação, pois a autorização
	 * bloqueia o valor do pedido no cartão do cliente e garante o
	 * pagamento para o estabelecimento "reservando" aquele valor.
	 * Contudo, a autorização sozinha não efetiva a transação, ela
	 * precisa ser capturada em seguida.
	 *
	 * @param string $orderId          Identificador do pedido no estabelecimento.
	 * @param float  $amount           Valor total do pedido, no formato americano de sepração decimal(0000.00).
	 * @param int    $paymentMethod    Código do meio de pagamento.
	 * @param string $cardHolder       Nome do portador impresso no cartão de crédito.
	 * @param string $cardNumber       Número do cartão de crédito com ou sem máscara.
	 * @param string $cardExpiration   Data de validade do cartão de crédito no formato MM/AA.
	 * @param int    $cardSecurityCode Código de segurança do cartão de crédito.
	 * @param int    $Installments     Número de parcelas.
	 * @param bool   $hasCharge        Define os júros do parcelamento(quando houver).
	 *                                 TRUE : Com júros (parcelamento Cartão)
	 *                                 FALSE: Sem júros (parcelamento Loja)
	 *
	 * @return Util_Payment_Adapter_Result_Authorization_Interface
	 * @throws Util_Payment_Adapter_Result_Exception
	 */
	public function authorize($orderId, $amount, $paymentMethod, $cardHolder, $cardNumber, $cardExpiration, $cardSecurityCode = 1, $hasCharge = false);
	
	/**
	 * Captura de uma transação.
	 *
	 * A Captura de uma transação CONFIRMA e COMPLETA aquele pedido.
	 *
	 * Um pedido nunca está completo se a captura não foi feita. Sem
	 * ela o estabelecimento NÃO GARANTE QUE RECEBERÁ o valor devido!
	 *
	 * Se a transação nunca for capturada o estabelecimento NÃO RECEBERÁ
	 * o dinheiro e o portador NÃO SERÁ COBRADO.
	 *
	 * Normalmente transações não capturadas são canceladas pelo
	 * próprio gateway de pagamento em alguns dias.
	 *
	 * A captura não faz nenhuma validação, ou seja, ela não verifica
	 * novamente os dados enviados na autorização. Ao pedir a captura
	 * o estabelecimento está apenas informando que ele quer, de fato,
	 * completar a venda.
	 *
	 * CAPTURA TOTAL X CAPTURA PARCIAL
	 *
	 * Algumas Adquirentes permitem que o estabelecimento faça uma captura
	 * parcial do pedido. Isto significa que, apesar de se ter uma autorização
	 * feita no valor total do pedido, o estabelecimento capturará apenas uma
	 * parte dela, deixando o resto do valor vencer.
	 *
	 * Capturas parciais são particularmente úteis em casos de indisponibilidade
	 * de estoque para todos os itens de um pedido.
	 *
	 * Opcionalmente pode-se passar como parâmetro para a captura um objeto
	 * de autorização retornado pelo método "authorize" desta mesma classe.
	 *
	 * @param mixed  $orderIdOrAuthorizeObject Identificador do pedido no estabelecimento ou abjeto de autorização.
	 * @param string $gatewayOrderId           Identificado do pedido no gateway de pagamento.
	 * @param float  $amount                   Valor a ser capturado, no formato americano de sepração decimal(0000.00).
	 *
	 * @return Util_Payment_Adapter_Result_Capture_Interface
	 * @throws Util_Payment_Adapter_Result_Exception
	 */
	public function capture($orderIdOrAuthorizeObject, $gatewayOrderId, $amount);
	
	/**
	 * Efetua uma autorização de crédito seguida de uma captura.
	 *
	 * A venda direta(ou "sale") combina a autorização e a captura em uma mesma chamada.
	 * Ao usar a requisição de venda direta você estará fazendo uma autorização no cartão
	 * de crédito do cliente e imediatamente executando uma captura total do valor.
	 *
	 * @param string $orderId          Identificador do pedido no estabelecimento.
	 * @param float  $amount           Valor total do pedido, no formato americano de sepração decimal(0000.00).
	 * @param int    $paymentMethod    Código do meio de pagamento.
	 * @param string $cardHolder       Nome do portador impresso no cartão de crédito.
	 * @param string $cardNumber       Número do cartão de crédito com ou sem máscara.
	 * @param string $cardExpiration   Data de validade do cartão de crédito no formato MM/AA.
	 * @param int    $cardSecurityCode Código de segurança do cartão de crédito.
	 * @param int    $Installments     Número de parcelas.
	 * @param bool   $hasCharge        Define os júros do parcelamento(quando houver).
	 *                                 TRUE : Com júros (parcelamento Cartão)
	 *                                 FALSE: Sem júros (parcelamento Loja)
	 *
	 * @return Util_Payment_Adapter_Result_Sale_Interface
	 * @throws Util_Payment_Adapter_Result_Exception
	 */
	public function sale($orderId, $amount, $paymentMethod, $cardHolder, $cardNumber, $cardExpiration, $cardSecurityCode = 1, $hasCharge = false);
	
	/**
	 * Cancela uma captura antes do fechamento do dia.
	 *
	 * IMPORTANTE: o Void só é permitido até as 23:59 do dia da captura.
	 *
	 * Se por alguma razão o pedido não pôde ser completado, e a transação já
	 * foi capturada, é possível cancelar a venda efetuada e anular a transação.
	 *
	 * Para efetuar um cancelamento de captura alguns gateways de pagamento pedem
	 * que seja enviado o ID que o pedido tem no sistema do COMERCIANTE, já outros
	 * pedem que o ID enviado seja o ID atribuído ao pedido pelo próprio GATEWAY no
	 * momento da captura.
	 *
	 * @param string $orderId Identificador do pedido.
	 * @return Util_Payment_Adapter_Result_Void_Interface
	 * @throws Util_Payment_Adapter_Result_Exception
	 */
	public function voidCapture($orderId);
	
	/**
	 * Estorna um pagamento.
	 *
	 * O estorno é a reversão de uma transação de cartão de crédito, debitando o valor
	 * do estabelecimento e devolvendo-o ao portador. o estorno é uma operação financeira
	 * e envolve outros departamentos dentro das adquirentes. por esta razão, em geral os
	 * estornos demoram alguns dias para serem aprovados.
	 *
	 * O estorno não depende do gateway de pagamento para ser aprovado.
	 *
	 * Segue o tempo médio de aprovação das operadoras de crédito:
	 *     Cielo   : 1-2 dias úteis
	 *     Redecard: 2-3 dias úteis
	 *     Amex    : Online, resposta imediata
	 *
	 * @param mixed  $merchantOrderId Identificador do pedido no estabelecimento.
	 * @param string $gatewayOrderId  Identificado do pedido no gateway de pagamento.
	 * @param float  $amount          Valor a ser estornado, no formato americano de sepração decimal(0000.00).
	 *
	 * @return Util_Payment_Adapter_Result_Charge_Interface
	 * @throws Util_Payment_Adapter_Result_Exception
	 */
	public function chargeReturn($merchantOrderId, $gatewayOrderId, $amount);
	
	/**
	 * Lança uma excessão.
	 *
	 * @param string $message Mensagem da excessão.
	 * @param int    $code    Código da excessão.
	 */
	protected function _exception($message, $code = 0)
	{
		require_once 'Util/Payment/Adapter/Braspag/Exception.php';
		throw new Util_Payment_Adapter_Braspag_Exception($message, $code);
	}
}





























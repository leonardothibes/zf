/**
 * Funções utilitárias do site.
 */
var Util =
{
	/**
	 * Inicia a configuração da tela.
	 */
	init: function()
	{
		Util.masks();
	},
	
	/**
	 * Inicia as máscaras de formatação de formulário.
	 */
	masks: function()
	{
		//Data.
		$('[alt="date"]').mask('99/99/9999').css('width', '130px').attr('autocomplete', 'off');
		
		//Hora e minuto.
		$('[alt="hour"]').mask('99:99').attr('autocomplete', 'off');
		
		//Hora, minuto e segundo.
		$('[alt="date_hour_sec"]').mask('99/99/9999 99:99:99').attr('autocomplete', 'off');
		
		//CPF.
		$('[alt="cpf"]').mask('999.999.999-99').css('width', '145px').attr('autocomplete', 'off');
		
		//CNPJ.
		$('[alt="cnpj"]').mask('99.999.999/9999-99').attr('autocomplete', 'off');
		
		//CEP.
		$('[alt="cep"]').mask('99999-999').attr('autocomplete', 'off');
		
		//Telefone.
		$('[alt="fone"]').mask('(99) 9999-9999').css('width', '130px').attr('autocomplete', 'off');
		
		//Cartão de crédito(Visa e Master).
		$('[alt="cc"]').css('width', '155px').attr('autocomplete', 'off').setMask();
		
		//Cartão de crédito American Express(Amex).
		$.mask.masks = $.extend($.mask.masks, {
			cc_amex: { mask: '9999 999999 99999' }
		});
		$('[alt="cc_amex"]').css('width', '155px').attr('autocomplete', 'off').setMask();
		
		//Data de expiração de cartão de crédito.
		$('[alt="ce"]').mask('99/99').css('width', '45px').attr('autocomplete', 'off');
		
		//Números inteiros.
		$('[alt="integer"]').setMask();
		
		//Números deciamis em formato brasileiro e europeu(0.000,00). Também serve para dinheiro.
		$('[alt="decimal"]').setMask();
		
		//Números decimais em formato americano(0,000.00). Também serve para dinheiro.
		$('[alt="decimal-us"]').setMask();
		
		//Números sem qualquer separador.
		$.mask.masks = $.extend($.mask.masks, {
			numeric: { mask: '9999999999' }
		});
		$('[alt="numeric"]').setMask();
	},
	
	/**
	 * Inicia a execussão de um loader.
	 * 
	 * @param string hide   Div/span que deve ser escondido durante a execussão do loader.
	 * @param string loader ID do elemento HTML a receber o loader.
	 * @param string image  Caminho para a imgem do loader(opcional).
	 */
	startLoader: function(hide, loader, image)
	{
		var loader = (loader != undefined) ? loader : 'sp_loader';
		var image  = (image  != undefined) ? image  : '/img/loader.gif';
		
		$('#' + loader).html('<img src="' + image + '" border="0" alt="" />');
		$('#' + hide).hide();
		$('#' + loader).show();
	},
	
	/**
	 * Para a execussão de um loader.
	 * 
	 * @param string show   Div/span que deve ser revelado após a execussão do loader.
	 * @param string loader ID do elemento HTML onde está o loader.
	 * 
	 * @return TS
	 */
	stopLoader: function(show, loader)
	{
		var loader = (loader != undefined) ? loader : 'sp_loader';
		
		$('#' + loader).html('');
		$('#' + loader).hide();
		$('#' + show).show();
	},
	
	/**
	 * Adiciona comportamentos de foco em campos de formulário.
	 * 
	 * @param string id    ID do campo no HTML.
	 * @param string label Conteúdo do campo.
	 * 
	 * @return TS
	 */
	frmFoco: function(id, label)
	{
		//Adicionando o "#" no ID caso já não tenha.
		id = id.substr(0, 1) == '#' ? id : '#' + id;
		
		//Preenchendo o campo pela primeira vez.
		$(id).val(label);
		
		//Colocando foco no campo.
		$(id).focus(function() {
			if($(this).val() == label) {
				$(this).val('');
			}
		});
		
		//Retirando foco do campo.
		$(id).blur(function() {
			if($(this).val() == '') {
				$(this).val(label);
			}
		});
		
		return this;
	},
	
	/**
	 * Converte números float para exibir na tela.
	 * 
	 * @param float num Número a ser convertido.
	 * @return string
	 */
	money: function(num) {
		return $().number_format(num, {
			numberOfDecimals: 2,
			decimalSeparator: ',',
			thousandSeparator: '.'
	    });
	}
}

$(document).ready(function() {
	Util.init();
});
define(['jquery'], function($){
    "use strict";
    $( document ).ready(function() {
        const existCondition = setInterval(function() {
            if ($('[name="telephone"]').length) {
                clearInterval(existCondition);
                fillCheckout();
            }
        }, 100);

        function fillCheckout() {
            const TELMaskBehavior = function(val) {
                    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                },
                telOptions = {
                    onKeyPress: function(val, e, field, options) {
                        field.mask(TELMaskBehavior.apply({}, arguments), options);
                    }
                };
            $('.validate-phone-mobile').mask(TELMaskBehavior, telOptions);
            $('[name="telephone"]').addClass('validate-phone-mobile').attr("placeholder", "(xx) 99999-1122");
            $('[name="postcode"]').mask('00000-000').blur('input',function() {
                buscaCep();
            });

        function buscaCep() {
            const urlBase = window.location.href.slice(0, -9);
            let cep = $('input[name*="postcode"]').val();
            cep = cep.replace(/[^0-9]+/g, "");
            if (cep !== '' && cep.length === 8) {
                $.getScript(window.location.origin + "/innovatis/checkcep/index?cep="+ cep + "", function() {
                    if (resultadoCEP["resultado"] !== 0) {
                        if (unescape(resultadoCEP["logradouro"])) $('input[name*="street[0]"]').val(unescape(resultadoCEP["tipo_logradouro"]) + " "+ unescape(resultadoCEP["logradouro"]));
                        if (unescape(resultadoCEP["bairro"])) $('input[name*="street[3]"]').val(unescape(resultadoCEP["bairro"]));

                        if (unescape(resultadoCEP["cidade"])) $('input[name*="city"]').val(unescape(resultadoCEP["cidade"]));

                        $('select[name*="region_id"]').find('option').each(function() {
                            if (this.text === estadoBR(unescape(resultadoCEP["uf"]))) {
                                this.selected = true;
                            }
                        });
                        $('input[name*="street[0]"]').change();
                        $('input[name*="city"]').change();
                        $('select[name*="region_id"]').change();
                        $('input[name*="street[1]"]').focus();
                        $('[name="street[1]"]').attr("placeholder", "Número");
                        $('[name="street[2]"]').attr("placeholder", "Complemento");
                    } else {
                        alert("Endereço não encontrado para o cep ");
                    }
                });
            }
        }

        function estadoBR(uf) {
            let estado;
            const obj = {
                'AC': 'Acre',
                'AL': 'Alagoas',
                'AM': 'Amazonas',
                'AP': 'Amapá',
                'BA': 'Bahia',
                'CE': 'Ceará',
                'DF': 'Distrito Federal',
                'ES': 'Espírito Santo',
                'GO': 'Goiás',
                'MA': 'Maranhão',
                'MT': 'Mato Grosso',
                'MS': 'Mato Grosso do Sul',
                'MG': 'Minas Gerais',
                'PA': 'Pará',
                'PB': 'Paraíba',
                'PR': 'Paraná',
                'PE': 'Pernambuco',
                'PI': 'Piauí',
                'RJ': 'Rio de Janeiro',
                'RN': 'Rio Grande do Norte',
                'RO': 'Rondônia',
                'RS': 'Rio Grande do Sul',
                'RR': 'Roraima',
                'SC': 'Santa Catarina',
                'SE': 'Sergipe',
                'SP': 'São Paulo',
                'TO': 'Tocantins'
            };
            $.each(obj, function(key, value) {
                if (key === uf) {
                    estado = value;
                }
            });
            return estado;
        }
    }});
});

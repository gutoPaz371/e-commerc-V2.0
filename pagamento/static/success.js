    // Função para obter os parâmetros da URL e transformá-los em um objeto JSON
    function getParamsAsJson() {
        // Obtém a string de query da URL (tudo após o '?')
        const queryString = window.location.search;
        
        // Cria um objeto URLSearchParams a partir da string de query
        const urlParams = new URLSearchParams(queryString);

        // Converte os parâmetros para um objeto
        const params = {};
        for (const [key, value] of urlParams.entries()) {
            params[key] = value;
        }

        // Converte o objeto para uma string JSON
        const json = JSON.stringify(params, null, 2);
        return json;
    }

    // Exibe o JSON no console (você pode adaptá-lo para exibir em outro lugar na página)
    const jsonParams = getParamsAsJson();
    console.log(jsonParams);
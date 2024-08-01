import mercadopago
def gerar_link_pagamento():
    sdk = mercadopago.SDK("TEST-5706462506921008-050300-e63cf13226a57e8fefac981aec297674-540037296")

    payment_data = {
        "items": [
            {
            "id": 1,
            "title": "Camisa", 
            "quantity": 1,
            "currency_id": "BRL",
            "unit_price": 150.66
            }
        ],
        "back_urls":{
            "success": "https://127.0.0.1:5000/compracerta",
            "failure": "https://127.0.0.1:5000/compraerrada",
            "peding": "https://127.0.0.1:5000/compraerrada"
        },
        "auto_return": "all"
    }
    result = sdk.preference().create(payment_data)
    payment = result["response"]
    return payment['init_point']
    
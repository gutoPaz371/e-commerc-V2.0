from flask import Flask, render_template
from api import gerar_link_pagamento
app = Flask(__name__)

@app.route('/processar')
def process():
    link = gerar_link_pagamento()
    return render_template()
    data = {'variable_name': 'value'}
    php_endpoint = './templates/homepage.php'
    response = requests.post(php_endpoint, data=data)
    return f'Status da requisição: {response.status_code}, Resposta: {response.text}'

@app.route("/")
def homepage():
    link = gerar_link_pagamento()
    return render_template("homepage.php", link_pagamento=link)

@app.route("/compracerta")
def compra_certa():
    return render_template("compracerta.html")

@app.route("/compraerrada")
def compra_errada():
    return render_template("compraerrada.html?u=teste")

if __name__ == "__main__":
    app.run()
    
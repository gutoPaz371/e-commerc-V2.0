from flask import Flask, request

app = Flask(__name__)
@app.route('/processar', methods=['POST'])
def processar():
    nome = request.form.get('nome')
    email = request.form.get('email')

    print(f"Nome: {nome}")
    print(f"Email: {email}")

    return "Dados recebidos com sucesso", 200

if __name__ == '__main__':
    app.run(debug=True)

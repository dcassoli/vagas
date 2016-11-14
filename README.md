<h3>Teste Catho Backend</h3>
<hr>
<p>API RESTFull GET para buscar vagas de um arquivo JSON disponibilizado, a partir de filtros parametrizados pré estabelecidos.</p>

<p><strong>Retorno:</strong> formato JSON com resultado da busca.</p>

<p><strong>Requerimentos:</strong> >= PHP 5.6</p>
		
<p><strong>Instalação:</strong></p>
<p>- Realizar o Git Clone do projeto.</p>
<p>- Executar o comando no shell no diretório do projeto, para atualizar as dependências:<br>
# php composer.phar install
</p>		

<p><strong>Funcionamento:</strong></p>

<p>GET http://www.example.com/vagas/busca/{filtro}/{valor}/{ordem} onde,<p>

<p>{filtro} = texto | cidade | salario</p>
<ul>
	<li>texto: qualquer texto que conste nos atributos "title" e "description" do JSON fornecido.</li>
	<li>cidade: qualquer cidade que conste no atributo "cidade".</li>
	<li>salario: o valor minimo de salario que conste no atributo "salario".</li>
</ul>
<p>{valor} = string de busca</p>
<p>{ordem} = asc | desc (default)</p>

<p><strong>Exemplos:</strong></p>
<p>GET http://SUA_URL_BASE/vagas/busca/texto/florianopolis/desc</p>

<p>Partindo que sua URL_BASE é localhost, temos os seguintes testes:</p>

<p># curl -i http://localhost/vagas/busca/texto/estagio/desc</p>
<p># curl -i http://localhost/vagas/busca/cidade/joinville/asc</p>
<p># curl -i http://localhost/vagas/busca/cidade/joinville</p>
<p># curl -i http://localhost/vagas/busca/salario/2000/asc</p>
		
<p><strong>Teste Unitário:</strong></p>
		
<p>Executar o comando no shell no diretório instalado:</p>
<p># php phpunit-5.6.2.phar test/RestApiTest.php</p>	
<p>Obs: Caso não tenha configurado em um localhost (http://localhost), alterar a linha #8 do arquivo de teste "test/RestApiTeste.php", com a URL base configurada.		
<br /><br />

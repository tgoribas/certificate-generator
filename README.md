# certificate-generator
<h3 align="left"> Gerador de Certificados </h3>

Uma ferramenta que gera arquivos PDFs de certificados de conclusão de curso a partir de dados de um CSV.

![Gif Generator](assets/images/gif-generator.gif)

<h3 align="left"> Tecnologias Usadas </h3>

* Jquery
* html2canvas.js
* Php Imagick
* Php Extension intl


<h3 align="left"> Configuração do Projeto </h3>

Na classe `php\Config.php` existem 3 variaveis para configuração:

* `URL`: Url do projeto
* `FOLDER`: Pasta do projeto
* `fileCSVS`: Arquivo CSV com os dados do certificado

<h3 align="left"> Arquivo CSV </h3>

CSV   | Dados
--------- | ------
name | Nome Completo
doc | Documento do Aluno (RG)
date | Data de Nascimento
gender | Genero do aluno
course | Nome do Curso
workload | Carga horaria
periodStart | Data de inicio do curso
periodEnd | Data de Finalização do curso

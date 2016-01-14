//Elegir una palabra aleatoria para el juego.
var palabras = new Array();
palabras[0] = "Accesibilidad";
palabras[1] = "Colombia";
palabras[2] = "Amoxicilina";
palabras[3] = "Epilepsia";
palabras[4] = "Filosofia";
palabras[5] = "Hipnosis";
palabras[6] = "Hornitorrinco";
palabras[7] = "Electricidad";
palabras[8] = "Actualizar";
palabras[9] = "Amor";

var palabra = palabras[Math.floor(Math.random() * 10)];

var hombre, l, espacio;

//Declaración de la clase Ahorcado.
var Ahorcado = function(con)
{
	this.contexto = con;
	this.maximo = 5;
	this.intentos = 0;
	this.vivo = true;
	this.dibujar();
}

//Declaración del metodo dibujar para la clase Ahorcado.
Ahorcado.prototype.dibujar = function()
{
	var dibujo = this.contexto;
	//Dibujando el poste.
	dibujo.beginPath();
	dibujo.moveTo(150,100);
	dibujo.lineTo(150,50);
	dibujo.lineTo(400,50);
	dibujo.lineTo(400,350);
	dibujo.lineWidth = 5;
	dibujo.strokeStyle = "#000";
	dibujo.stroke();
	dibujo.closePath();

	if(this.intentos > 0)
	{
		//Intentos = 1 --> rostro
		dibujo.beginPath();
		dibujo.arc(150, 140, 40, 0, Math.PI * 2, false);
		dibujo.strokeStyle = "#D8A05F";
		dibujo.lineWidth = 5;
		dibujo.stroke();
		dibujo.closePath();

		if (this.intentos > 1)
		{
			//Intentos = 2 --> tronco
			dibujo.beginPath();
			dibujo.moveTo(150,180);
			dibujo.lineTo(150,250);
			dibujo.strokeStyle = "#D8A05F"
			dibujo.lineWidth = 5;
			dibujo.stroke();
			dibujo.closePath();

			if (this.intentos > 2)
			{
				//Intentos = 3 --> brazos
				dibujo.beginPath();
				dibujo.moveTo(120,220);
				dibujo.lineTo(150,180);
				dibujo.lineTo(180,220);
				dibujo.strokeStyle = "#D8A05F"
				dibujo.lineWidth = 5;
				dibujo.stroke();
				dibujo.closePath();

				if (this.intentos > 3)
				{
					//Intentos = 4 --> piernas
					dibujo.beginPath();
					dibujo.moveTo(120,290);
					dibujo.lineTo(150,250);
					dibujo.lineTo(180,290);
					dibujo.strokeStyle = "#D8A05F"
					dibujo.lineWidth = 5;
					dibujo.stroke();
					dibujo.closePath();

					if (this.intentos > 4)
					{
						//Intentos = 5 --> ojos muertos
						dibujo.beginPath();
						//Ojo izquierdo
						dibujo.moveTo(125,120);
						dibujo.lineTo(145,145);
						dibujo.moveTo(145,120);
						dibujo.lineTo(125,145);
						//Ojo derecho
						dibujo.moveTo(155,120);
						dibujo.lineTo(175,145);
						dibujo.moveTo(175,120);
						dibujo.lineTo(155,145);

						dibujo.strokeStyle = "black"
						dibujo.lineWidth = 5;
						dibujo.stroke();
						dibujo.closePath();
					}
				}
			}
		}
	}

}

//Definicion de metodo trazar que se encarga de aumentar el
//número de intentas y de dispara la funcion dibujar del cuerpo
//del ahorcado.
Ahorcado.prototype.trazar = function()
{
	this.intentos++;
	if(this.intentos >= this.maximo)
	{
		this.vivo = false;
	}

	this.dibujar();
}

//Funcion que obtiene el contexto del canvas para el dibujo,
//y asiganar a la variable hombre una instancia de la clase 
//Ahorcado y pasarle por parametro el contexto del canvas. 
function iniciar() {
	l = document.getElementById("letra");
	var b = document.getElementById("boton");

	var canvas = document.getElementById("c");
	canvas.width = 500;
	canvas.height = 400;
	var contexto = canvas.getContext("2d");
	hombre = new Ahorcado(contexto);

	//Convierte un string a mayusculas.
	palabra = palabra.toUpperCase();

	//Declaro array con el espacio de la plabra.
	espacio = new Array(palabra.length);

	//Agregamos una funcion que se dispare con un click.
	b.addEventListener("click", agregarLetra);

	mostrarPista(espacio);
}

//Funcion encargada de tomar el valor del input text, es decir
//la letra y retornala a la funcion mostrarPalabra.
function agregarLetra()
{
	var letra = l.value;
	l.value = "";
	mostrarPalabra(palabra, hombre, letra);
}

//Función encargada de recorrer la plabra y validar coincidencias
//en letras, si la letra existe es almacenada en la variable espacio
//y la retorna a la funcion mostrarPista. 
function mostrarPalabra(palabra, ahorcado, letra)
{
	var encontrado = false;
	var p;
	letra = letra.toUpperCase();

	for(p in palabra)
	{
		if(letra == palabra[p])
		{
			espacio[p] = letra;
			encontrado = true;
		}
	}

	mostrarPista(espacio);

	if(!encontrado)
	{
		ahorcado.trazar();
	}

	if(!ahorcado.vivo)
	{
		alert("Estas muerto X_X!!");
		mostrarPista(palabra);
	}
}

//Esta función se encarga de dibujar la letra o el espacio
//en la pista.
function mostrarPista(espacio)
{	
	var pista = document.getElementById("pista");
	var texto = ""; 
	var i;
	var largo = espacio.length;

	for(i = 0; i < largo; i++)
	{
		if(espacio[i] != undefined)
		{
			texto = texto + espacio[i] + " ";
		}
		else
		{
			texto += "_ ";
		}
	}

	pista.innerText = texto;
}
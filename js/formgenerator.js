

const script = document.createElement('script');
script.type = 'text/javascript';
script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js';  

const script2 = document.createElement('script');
script2.type = 'text/javascript';
script2.src = 'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js';  


document.head.appendChild(script);
setTimeout(() => {
    document.head.appendChild(script2);
}, 500);


function onSubmit(token) {
	const input = document.createElement('input');
	input.type = 'hidden';
	input.name = 'recaptcha_token';
	input.value = token;
  
  let form = $( ".contact-form" );
  form.validate({
    rules: {
      nombre : {
        required: true,
        minlength: 3
      },
      telefono: {
        required: true,
        number: true,
        maxlength: 13,
        minlength: 6
      },
      email: {
        required: true,
        email: true,
      }
    },
    messages : {
      nombre: {
        required: "Este campo es obligatorio",
        minlength: "El nombre es muy corto"
      },
      telefono: {
        required: "Este campo es obligatorio",
        minlength: "Ingresa un numero de teléfono valido",
        number: "Solo numeros"
      },
      email: {
        required: "Este campo es obligatorio",
        email: "Formato debe ser: abc@dominio.com"
      }
    }
  });
  if(form.valid()){
    alert("enviando");
  }
}

function parseQuery ( query ) {
   const Params = {};
   if ( ! query ) return Params; 
   const Pairs = query.split(/[;&]/);
   for ( let i = 0; i < Pairs.length; i++ ) {
      const KeyVal = Pairs[i].split('=');
      if ( ! KeyVal || KeyVal.length != 2 ) continue;
      const key = unescape( KeyVal[0] );
      let val = unescape( KeyVal[1] );
      val = val.replace(/\+/g, ' ');
      Params[key] = val;
   }
   return Params;
}


const scripts = document.getElementsByTagName('script');
let myScript = null;

for (let i = 0; i < scripts.length; i++) {
  if (scripts[i].src.indexOf('formgenerator') > -1){
    myScript = scripts[i];
  }
}

const queryString = myScript.src.replace(/^[^\?]+\??/, '');
const params = parseQuery(queryString);
const zapierUrl = `https://hooks.zapier.com/hooks/catch/${params.zapier1}/${params.zapier2}/`;
window.addEventListener('load', function () {
  const fileExt = params.fileExt ? params.fileExt : 'php';
  const errorUrl = `${params.errorUrl}.${fileExt}`;
  const successUrl = `${params.successUrl}.${fileExt}`;
  const sendByInput = params.sendByInput ? params.sendByInput : false;
  const siteInput = document.createElement("input");
  const submitAction = (event) => {
    event.preventDefault();
    try {
      const response = grecaptcha.getResponse();
      if( response.length === 0) {
        console.log(`Error ${xhr.status}: ${xhr.statusText}`);
        window.location.href = errorUrl;
        return false;
      }
    } catch {
      console.log('no recaptcha');
    }
    
    const formData = new FormData(document.forms[0]);
    if (formData.get('url') !== '') {
      const xhr = new XMLHttpRequest();
      xhr.open("POST", zapierUrl);
      xhr.send(formData);
      xhr.onload = function() {
        if (xhr.status != 200) {
          console.log(`Error ${xhr.status}: ${xhr.statusText}`);
          window.location.href = errorUrl;
        } else {
          console.log(`Hecho, obtenidos ${xhr.response.length} bytes`);
          window.location.href = successUrl;
        }
      };

      xhr.onerror = function() {
        window.location.href = errorUrl;
    };

    return event.preventDefault();
    }
  };


  Array.from(document.querySelectorAll("form.contact-form")).forEach(function(element) {
    const input = document.createElement("input");
    const devInput = document.createElement("input");
    input.setAttribute("type", "text");
    input.classList.add('nobotinput');
    input.setAttribute("name", "url");
    devInput.setAttribute("type", "hidden");
    devInput.setAttribute("name", "site");
    devInput.setAttribute("value", params.site);
    element.appendChild(devInput);
    element.appendChild(input);

    if (false) {
      if (!!element.querySelector('input[type=submit]')) {
        const input2 = element.querySelector('input[type=submit]');
        input2.addEventListener('click', submitAction, {once: true});
      } else {
        element.addEventListener('submit', submitAction);
      }  
    }

  })

});


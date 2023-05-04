// SCRIPTS LOGIN

const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

if(signInButton && signUpButton) {
	signUpButton.addEventListener('click', () => {
		container.classList.add("right-panel-active");
	});
	signInButton.addEventListener('click', () => {
		container.classList.remove("right-panel-active");
	});
}

// SCRIPTS INDEX

$(document).ready(function() {
    if(document.getElementById('bodyIndex')){
      var sections = $('.section');
      var currentSection = 0;

      $(window).scroll(function() {
          var currentPosition = $(this).scrollTop();
          var nextSection = currentSection + 1;
          var prevSection = currentSection - 1;
          console.log(currentSection);

          if (currentPosition > sections.eq(currentSection).offset().top + sections.eq(currentSection).outerHeight() - $(window).height()) {
            if (!$('html, body').is(':animated')) {
              currentSection = nextSection;
              sections.eq(currentSection).find('.tarjeta').addClass('appear');
              if (currentSection === 1) {
                $('.header-fixed').addClass('header-logo');
                $('.logo').addClass('logo-small');
                $('.nav-menu').addClass('nav-menu-logo');
              }
              $('html, body').animate({
                scrollTop: sections.eq(currentSection).offset().top
              }, 1000);
            }
          } else if (prevSection >= 0 && currentPosition < sections.eq(prevSection).offset().top + sections.eq(prevSection).outerHeight() - $(window).height()) {
            if (!$('html, body').is(':animated')) {
              currentSection = prevSection;
              sections.eq(currentSection).find('.tarjeta').addClass('appear');
              if (currentSection === 0) {
                console.log(currentSection);
                $('.header-fixed').removeClass('header-logo');
                $('.logo').removeClass('logo-small');
                $('.nav-menu').removeClass('nav-menu-logo');
              }
              
              // Poner animacion al scroll up
              // $('html, body').animate({
              //   scrollTop: sections.eq(currentSection).offset().top
              // }, 1000);
            }
          }
      });
    }
    
});

// Menu Perfil

$(document).ready(function() {
    // Ocultar inicialmente los elementos del menú de perfil
    $("#menu-perfil li").hide();

    // Agregar animación al botón de perfil
    $("#toggleButton").click(function() {
        // Alternar la clase 'hidden' en el menú de perfil
        $("#menu-perfil").toggleClass('hidden');

        // Mostrar u ocultar los elementos del menú de perfil con animación de desvanecimiento lento
        $("#menu-perfil li").each(function(index) {
            $(this).delay(200 * index).fadeToggle("slow");
        });
    });
});


// Cambiar Foto Perfil

$(document).ready(function() {
  if(document.getElementById("inpFotoPerfil")){
    document.getElementById("inpFotoPerfil").addEventListener("change", function(event) {
      var input = event.target;
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
              document.getElementById("previewFotoPerfil").src = e.target.result;
          };
          reader.readAsDataURL(input.files[0]);
      }
    });
  }
  
});

$(document).ready(function() {
  if(document.getElementById("inpFotoPerfil")){
    $('#inpFotoPerfil').on('change', function() {
      // Mostrar u ocultar el botón de guardar según si se selecciona una imagen nueva
      if (this.files && this.files[0]) {
          $('#btnGuardar').show();
      } else {
          $('#btnGuardar').hide();
      }
    });
  }
  
});

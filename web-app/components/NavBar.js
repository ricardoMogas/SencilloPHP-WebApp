// webComponent.js
class NavBar extends HTMLElement {
    constructor() {
      super();
      this.attachShadow({ mode: 'open' });
      // Estado inicial si es necesario
      this.state = {
        message: '',
      };
    }
  
    connectedCallback() {
        this.state.message = this.getAttribute('message') || 'Mensaje predeterminado';
        this.render();
    }
  
    // Métodos y lógica del componente
  
    render() {
      this.shadowRoot.innerHTML = `
        <style>
        nav {
            padding: 20px;
            background-color: #000000;
            color: #fff;
            border-radius: 5px;
            text-align: center;
        }
        
        a{
            padding: 5px;   
            color: #fff;
            text-decoration: none;
        }
        .title {
          margin: 10px;
        }
        </style>
        <nav>
            <h3 class='title'>${this.state.message}</h3>
            <a href="page/">Home</a>
            <a href="page/about">About</a>
            <a href="help">help</a>
        </nav>
      `;
    }
  }
  
  // Definir el nuevo elemento personalizado
  customElements.define('nav-bar', NavBar);
  
import Ajax from './libs/ajax';

/**
 * Class for a sample page - Register.
 * @constructor
 */
class Register {
  constructor() {
    this.ajaxToForm();
  }

  ajaxToForm() {
    const register = document.querySelector('form#register');

    if (register) {
      const ajax = new Ajax(register);
      ajax.run();
    }
  }
}

export default new Register;
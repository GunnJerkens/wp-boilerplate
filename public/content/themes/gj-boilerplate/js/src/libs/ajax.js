/**
 * Class for forms that requires ajax.
 */
function Ajax(el) {
  this.el      = $(el);
  this.id      = $(el).attr('id');
  this.btn     = $(el).children('button[type="submit"]');
  this.thanks  = $(el).children('.thanks');
  this.error   = $('#error');
  this.options = formOptions;
  this.output  = { status: 'success', message: 'All fields complete.', element: null };
}

Ajax.prototype.run = function() {
  var self = this;

  this.el.on('submit',function(e) {
    e.preventDefault();
    var data  = $(this).serialize();

    self.checkFields();

    if(self.output.status !== 'error') {
      $(this.btn).toggle();
      self.error.empty();
      self.error.append('<p class="message"><i class="fa fa-spin fa-spinner"></i> Sending...</p>');

      $.post(self.options.ajaxurl, {
        action : 'register',
        nonce  : self.options.nonce,
        post   : data
      },
      function(response) {
        self.successMessage(response);
        
        // google tag manager custom event
        if(typeof dataLayer !== 'undefined') {
          dataLayer.push({'event': 'formSubmitted'});
        }
      });
    } else {
      self.errorOutput();
    }
  });
}

Ajax.prototype.checkFields = function() {
  console.log('checkFields');
  var self = this;
  this.clearErrors();

  this.el.find(':input').each(function() {
    var el, attr, type, value, input_name, field_name, group_checked;
    el    = $(this);
    attr  = el.attr('required');
    type  = el.attr('type');
    value = el.val();
    input_name = el.attr('name');

    if(typeof attr !== typeof undefined && attr !== false) {
      field_name = el.prev('label').text();
      field_name = field_name.replace('*', '');

      if(value === "" || value === null) {
        self.setOutput('error','<i class="fa fa-close"></i> "' + field_name + '" is required.', el);
        return false;
      }

      if(('radio' === type || 'checkbox' === type) && !el.is(':checked')) {
        group_checked = false;
        $('[name="'+input_name+'"]').each(function(){
          if ($(this).is(':checked')) {
            group_checked = true;
            return false;
          }
        });
        if (!group_checked) {
          self.setOutput('error', '<i class="fa fa-close"></i> "' + field_name + '" is required.', el);
          return false;
        }
      }

      if('email' === type && false === self.looseEmailValidate(value)) {
        self.setOutput('error', '<i class="fa fa-close"></i> Your email is not valid.', el);
        return false;
      }

      if(input_name === "zip" && value.length < 5 || input_name === "zip" && isNaN(value)) {
        self.setOutput('error', '<i class="fa fa-close"></i> Please enter a valid zip code.', el);
        return false;
      }

    } else {
      self.setOutput('success', 'All fields complete.', null);
    }
  });
};

Ajax.prototype.setOutput = function(status, message, el) {
  this.output.status  = status;
  this.output.message = message;
  this.output.element = el;
};

Ajax.prototype.looseEmailValidate = function(email) {
  var re = /\S+@\S+\.\S+/;
  return re.test(email);
};

Ajax.prototype.clearErrors = function() {
  $('.has-error').removeClass('has-error');
  this.error.empty();
};

Ajax.prototype.errorOutput = function() {
  this.error.append(this.output.message);
  $('input, select, .form-group').removeClass('has-error');
  if(this.output.element !== null) {
    this.output.element.closest('div.form-group').addClass('has-error');
  }
};

Ajax.prototype.successMessage = function(data) {
  var formChildren = $(this.id).children().not('.thanks'),
      response = JSON.parse(data);

  if (response.status === 'success') {
    $(formChildren).fadeOut(300);
    this.el.html(this.thanks);
  } else {
    this.error.empty();
    this.error.append(response.message);
    $(this.btn).toggle();
  }
};

export default Ajax;

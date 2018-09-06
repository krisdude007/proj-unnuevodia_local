(function(/*! Brunch !*/) {
  'use strict';

  var globals = typeof window !== 'undefined' ? window : global;
  if (typeof globals.require === 'function') return;

  var modules = {};
  var cache = {};

  var has = function(object, name) {
    return ({}).hasOwnProperty.call(object, name);
  };

  var expand = function(root, name) {
    var results = [], parts, part;
    if (/^\.\.?(\/|$)/.test(name)) {
      parts = [root, name].join('/').split('/');
    } else {
      parts = name.split('/');
    }
    for (var i = 0, length = parts.length; i < length; i++) {
      part = parts[i];
      if (part === '..') {
        results.pop();
      } else if (part !== '.' && part !== '') {
        results.push(part);
      }
    }
    return results.join('/');
  };

  var dirname = function(path) {
    return path.split('/').slice(0, -1).join('/');
  };

  var localRequire = function(path) {
    return function(name) {
      var dir = dirname(path);
      var absolute = expand(dir, name);
      return globals.require(absolute, path);
    };
  };

  var initModule = function(name, definition) {
    var module = {id: name, exports: {}};
    cache[name] = module;
    definition(module.exports, localRequire(name), module);
    return module.exports;
  };

  var require = function(name, loaderPath) {
    var path = expand(name, '.');
    if (loaderPath == null) loaderPath = '/';

    if (has(cache, path)) return cache[path].exports;
    if (has(modules, path)) return initModule(path, modules[path]);

    var dirIndex = expand(path, './index');
    if (has(cache, dirIndex)) return cache[dirIndex].exports;
    if (has(modules, dirIndex)) return initModule(dirIndex, modules[dirIndex]);

    throw new Error('Cannot find module "' + name + '" from '+ '"' + loaderPath + '"');
  };

  var define = function(bundle, fn) {
    if (typeof bundle === 'object') {
      for (var key in bundle) {
        if (has(bundle, key)) {
          modules[key] = bundle[key];
        }
      }
    } else {
      modules[bundle] = fn;
    }
  };

  var list = function() {
    var result = [];
    for (var item in modules) {
      if (has(modules, item)) {
        result.push(item);
      }
    }
    return result;
  };

  globals.require = require;
  globals.require.define = define;
  globals.require.register = define;
  globals.require.list = list;
  globals.require.brunch = true;
})();
require.register("application", function(exports, require, module) {
// this file extends backbone.validation to work with bootstrap form classes
require('lib/backbone.validation.for.bootstrap');
// this is required for marionette to run with brunch.
require('lib/marionette.brunch');
require('lib/view_helper');
require('lib/backbone.routefilter.min');


var App = Backbone.Marionette.Application.extend({
  root: '',       // The root path to run the application through.
  // BaseURL: 'http://localhost:8888/univision/public/',        // The Base application URL
  // API: '', // Base API URL (used by models & collections

  initialize: function() {
    var _this = this;

    this.on('initialize:after', function(options) {
      // Backbone.history.start();
      return typeof Object.freeze === "function" ? Object.freeze(_this) : void 0;
    });

    this.addInitializer(function(options){
      var AppLayout = require('views/AppLayout');
      _this.layout = new AppLayout();
      _this.layout.render();

      // FAKE REMOVE THIS
      // Toggle the visibility of login and logout buttons based on which is clicked
      $('#snap-drawer-login-btn, #snap-drawer-logout-btn').click(function(){
        $('#snap-drawer-login-btn, #snap-drawer-logout-btn').toggleClass('hidden');
      });

      // Initialize Fastclick.js
      // If you are emulating a device in a browser, ie chrome browser emulation,
      //  you must disable this for clicks to work

      $(function() {
          FastClick.attach(document.body);
      });

      // Initialize Snap.js
      var snapper = new Snap({
                element: document.getElementById('content-container'),
                disable: 'right',
                touchToDrag: false
            });

      var addEvent = function addEvent(element, eventName, func) {
        if (element.addEventListener) {
            return element.addEventListener(eventName, func, false);
          } else if (element.attachEvent) {
              return element.attachEvent("on" + eventName, func);
          }
      };

      // when the user clicks the hamburger icon, open or close the menu accordingly
      addEvent(document.getElementById('open-left'), 'click', function(e){
        e.preventDefault();

        if( snapper.state().state=="left" ){
          snapper.close();
        } else {
          snapper.open('left');
        }
      });

      // when the user clicks the login/logout button or a nav item, close the drawer
      $('#snap-drawer-login-btn, #nav, #snap-drawer-logout-btn').click(function(e){
        if( snapper.state().state=="left" ){
          snapper.close();
        };
      });

      /* view container still wants to display high res image as background on static pages */

      // $(document).bind('DOMNodeInserted', function(e){
      //   console.log(e.target, ' was inserted');
      //   var eleId = $(e.target).attr('id');
      // });

      /* Prevent Safari opening links when viewing as a Mobile App */
      (function (a, b, c) {
          if(c in b && b[c]) {
              var d, e = a.location,
                  f = /^(a|html)$/i;
              a.addEventListener("click", function (a) {
                  d = a.target;
                  while(!f.test(d.nodeName)) d = d.parentNode;
                  "href" in d && (d.href.indexOf("http") || ~d.href.indexOf(e.host)) && (a.preventDefault(), e.href = d.href)
              }, !1)
          }
      })(document, window.navigator, "standalone");

      });

    this.addInitializer(function(options){
      var Router = require('lib/router');
      _this.router = new Router();
    });

  }
});

module.exports = new App();

});

;require.register("initialize", function(exports, require, module) {
// require('lib/facebook-auth');
var app = require('application');
var UserSessionModel = require('models/user-session-model');

$(document).ready(function() {

  app.initialize();

  app.addInitializer(function(options){

    // Create a new session model and scope it to the app global
    // This will be a singleton, which other modules can access
    // the router in particular will check this userSessionModel 
    // to check for permissions for protected routes.
    this.userSessionModel = new UserSessionModel({});

    // var hasPushState = !!(window.history && history.pushState);
    // if (hasPushState) {
    //   Backbone.history.start({pushState: true, root: app.root});
    // }
    // else {
    //   Backbone.history.start();
    // }

    Backbone.history.start();
    
    // Globally capture clicks.  If they are internal and not in the pass
    // through list, route them through Backbone's navigate method.
    $(document).on("click", "a[href^='/']", function(event) {
      var href, passThrough, url;
      href = $(event.currentTarget).attr('href');

      // add more black list routes with || 
      passThrough = href.indexOf('sign_out') >= 0;
      // allow shift+click for new tabs
      if (!passThrough && !event.altKey && !event.ctrlKey && !event.metaKey && !event.shiftKey) {
        event.preventDefault();
        // remove leading slashes and hash bangs (backward compatability)
        url = href.replace(/^\//, '').replace('\#\!\/', '');

        // instruct backbone to trigger routing events 
        app.router.navigate(url, {trigger: true});
        return false;
      }
    });

  });

  app.start();

});
  
  

});

;require.register("lib/backbone.routefilter.min", function(exports, require, module) {
/*! backbone.routefilter - v0.2.0 - 2013-02-16
* https://github.com/boazsender/backbone.routefilter
* Copyright (c) 2013 Boaz Sender; Licensed MIT */
(function(a,b){var c=a.Router.prototype.route,d=function(){};b.extend(a.Router.prototype,{before:d,after:d,route:function(a,e,f){f||(f=this[e]);var g=b.bind(function(){var c=[a,b.toArray(arguments)],e;b.isFunction(this.before)?e=this.before:typeof this.before[a]!="undefined"?e=this.before[a]:e=d;if(e.apply(this,c)===!1)return;f&&f.apply(this,arguments);var g;b.isFunction(this.after)?g=this.after:typeof this.after[a]!="undefined"?g=this.after[a]:g=d,g.apply(this,c)},this);return c.call(this,a,e,g)}})})(Backbone,_);
});

;require.register("lib/backbone.validation.for.bootstrap", function(exports, require, module) {
// Extend the callbacks to work with Bootstrap, as used in this example
// See: http://thedersen.com/projects/backbone-validation/#configuration/callbacks
_.extend(Backbone.Validation.callbacks, {
    valid: function (view, attr, selector) {
        var $el = view.$('[name=' + attr + ']'), 
            $group = $el.closest('.form-group');
        
        $group.removeClass('has-error');
        $group.find('.help-block').html('').addClass('hidden');
    },
    invalid: function (view, attr, error, selector) {
        var $el = view.$('[name=' + attr + ']'), 
            $group = $el.closest('.form-group');
        
        $group.addClass('has-error');
        $group.find('.help-block').html(error).removeClass('hidden');
    }
});
});

;require.register("lib/facebook-auth", function(exports, require, module) {
var app = require('application');
window.fbAsyncInit = function() {
FB.init({
  appId      : 431456823624528,
  status     : true, // check login status
  cookie     : true, // enable cookies to allow the server to access the session
  xfbml      : true  // parse XFBML
});

FB.Event.subscribe('auth.authResponseChange', function(response) {
  // Here we specify what we do with the response anytime this event occurs. 
  if (response.status === 'connected') {
    // The response object is returned with a status field that lets the app know the current
    // login status of the person. In this case, we're handling the situation where they 
    // have logged in to the app.
    updateUserSessionModel();

  } else if (response.status === 'not_authorized') {
    // In this case, the person is logged into Facebook, but not into the app, so we call
    // FB.login() to prompt them to do so. 
    // In real-life usage, you wouldn't want to immediately prompt someone to login 
    // like this, for two reasons:
    // (1) JavaScript created popup windows are blocked by most browsers unless they 
    // result from direct interaction from people using the app (such as a mouse click)
    // (2) it is a bad experience to be continually prompted to login upon page load.
    FB.login();
  } else {
    // In this case, the person is not logged into Facebook, so we call the login() 
    // function to prompt them to do so. Note that at this stage there is no indication
    // of whether they are logged into the app. If they aren't then they'll see the Login
    // dialog right after they log in to Facebook. 
    // The same caveats as above apply to the FB.login() call here.
    FB.login();
  }
});
};

function updateUserSessionModel() {
  FB.api('/me', function(response) {
    console.log('app', app);
    app.userSessionModel.set(_.extend(response,{'loggedIn': true}));
  });
}

// Load the SDK asynchronously
(function(d){
  console.log('Load the SDK asynchronously')
 var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
 if (d.getElementById(id)) {return;}
 js = d.createElement('script'); js.id = id; js.async = true;
 js.src = "//connect.facebook.net/en_US/all.js";
 ref.parentNode.insertBefore(js, ref);
}(document));
});

;require.register("lib/marionette.brunch", function(exports, require, module) {
// This makes Marionette work with brunch.  not sure why or how. 
Backbone.Marionette.Renderer.render = function(templateName, data) {
  var template;
  if (_.isFunction(templateName)) {
    template = templateName;
  } else {
    template = require(templateName);
  }
  return template(data);
};

});

;require.register("lib/router", function(exports, require, module) {
var app = require('application');
var UserModel = require('models/user-model');
var SignUpView = require('views/sign-up-view');
var HomeView = require('views/home-view');
var UserCollection = require('models/user-collection');
var LoginView = require('views/login-view');
var BaseModalView = require('views/base-modal-view');
var StaticView = require('views/static-view');
var TelemundoPrivacyPolicyTemplate = require('views/templates/static-view-templates/telemundo-privacy-policy');
var TelemundoTermsOfUseTemplate = require('views/templates/static-view-templates/telemundo-terms-of-use');
var YoutooPrivacyPolicyTemplate = require('views/templates/static-view-templates/youtoo-privacy-policy');
var YoutooTermsOfUseTemplate = require('views/templates/static-view-templates/youtoo-terms-of-use');
var EligibilityRequirementsTemplate = require('views/templates/static-view-templates/eligibility-requirements');
var HowToAuditionTemplate = require('views/templates/static-view-templates/how-to-audition');
var OpenMicAuditionsTemplate = require('views/templates/static-view-templates/open-mic-auditions');
var HomeView = require('views/home-view');
var ForgotPasswordView = require('views/forgot-password');
var TopicsView = require('views/topics-view');
var ReviewView = require('views/review-view');
var ProcessingVideoView = require('views/processing-video-view');
var VideoUploadSuccess = require('views/video-upload-success-view');

// We are extending from backbone.routefilter.
// https://github.com/boazsender/backbone.routefilter.  Which provides before and after filters for Backbone.Router.

module.exports = Backbone.Router.extend({
  routes: {
    '': 'home',
    'login': 'login',
    'users':'displayUsers',
    'users/:id': 'displayUser',
    'sign_up':'signup',
    'privacy_policy': 'privacyPolicy',
    'terms_of_use': 'termsOfUse',
    'forgot_password': 'forgotPassword',
    'home': 'home',
    'upload': 'upload',
    'topics': 'topics',
    'review': 'review',
    'processing_video': 'processingVideo',
    'video_upload_success': 'videoUploadSuccess',
    'eligibility_requirements' : 'eligibilityRequirements',
    'how_to_audition' : 'howToAudition',
    'open_mic_auditions' :'openMicAuditions',
    'telemundo_privacy_policy' : 'telemundoPrivacyPolicy',
    'telemundo_terms_of_use' : 'telemundoTermsOfUse',
    'youtoo_privacy_policy' : 'youtooPrivacyPolicy',
    'youtoo_terms_of_use' : 'youtooTermsOfUse'
  },

  // add protected routes here, like so
  // protectedRoutes: ['home', 'upload', 'view_videos'],
  protectedRoutes: [],

  before: function(){
    // before route() is called
    this.checkProtectedRoute(window.location.href);

  },

  after: function(){
    // after route() is called
    this.addActiveClassToNavItem(Backbone.history.getFragment());
    // reset the scroll of the container of the views.
    $('#fabmob_view-container').scrollTop('0');
  },

  addActiveClassToNavItem: function(){
    var $navLi = $('.snap-drawers').find('#nav li');
    $navLi.removeClass('fabMob_active-nav-li');
    $.each($navLi.find('a'), function(idx, link){
      var indexOfHref = window.location.href.indexOf($(link).attr('href'));
      if (indexOfHref > -1){
        $(link).parent('li').addClass('fabMob_active-nav-li');
        return;
      }
    })
  },

  checkProtectedRoute: function(path){
    // check if the route is protected
    var route = path.split('#')[1]
    if ( _.indexOf(this.protectedRoutes, route)  > -1) {
      if (app.userSessionModel.get('loggedIn')) {
        // console.log('user is authenticated');
        return true;
      }
      else {
        // console.log('user is not authenticated');
        // redirect to login
        this.navigate('login', {replace:true, trigger: true});
        return false;
      }
    }
    else {
      // the route is unprotected
      // console.log('the route is not protected');
      return true;
    }
  },

  home: function(){
    var homeView = new HomeView();
    app.layout.content.show(homeView);
  },

  signup: function(){
    var userModel = new UserModel();
    var signUpView = new SignUpView({model:userModel});
    app.layout.content.show(signUpView);
  },

  login: function() {
    var loginView = new LoginView();
    app.layout.content.show(loginView);
  },

  telemundoPrivacyPolicy: function(){
    var staticView = new StaticView({template: TelemundoPrivacyPolicyTemplate});
    app.layout.content.show(staticView);
  },

  telemundoTermsOfUse: function(){
    var staticView = new StaticView({template: TelemundoTermsOfUseTemplate});
    app.layout.content.show(staticView);
  },
  youtooPrivacyPolicy: function(){
    var staticView = new StaticView({template: YoutooPrivacyPolicyTemplate});
    app.layout.content.show(staticView);
  },

  youtooTermsOfUse: function(){
    var staticView = new StaticView({template: YoutooTermsOfUseTemplate});
    app.layout.content.show(staticView);
  },
  forgotPassword: function(){
    var forgotPasswordView = new ForgotPasswordView();
    app.layout.content.show(forgotPasswordView);
  },

  review: function(){
    var reviewView = new ReviewView();
    app.layout.content.show(reviewView);
  },

  processingVideo: function(){
    var processingVideoView = new ProcessingVideoView();
    app.layout.content.show(processingVideoView);
  },

  videoUploadSuccess: function(){
    var videoUploadSuccess = new VideoUploadSuccess();
    app.layout.content.show(videoUploadSuccess);
  },


  upload: function(){
    var topicsView = new TopicsView();
    app.layout.content.show(topicsView);
  },

  eligibilityRequirements: function() {
    var staticView = new StaticView({template: EligibilityRequirementsTemplate});
    app.layout.content.show(staticView);
  },

  howToAudition: function() {
    var staticView = new StaticView({template: HowToAuditionTemplate});
    app.layout.content.show(staticView);
  },
  
  openMicAuditions: function() {
    var staticView = new StaticView({template: OpenMicAuditionsTemplate});
    app.layout.content.show(staticView);
  },
});

});

;require.register("lib/user-session-helper", function(exports, require, module) {
var app = require('application');
module.exports = {
  login: function(e){
    e.preventDefault();
    $('.alert-error').hide();
    var url = app.API + 'login';
    var data = $('#js-login-form').serializeObject();
    $.ajax({
      url:url,
      type:'POST',
      dataType: 'json',
      data: data,
      success:function(data){
        if (data.error){
          console.log('error! you were not logged in');
        } else {
          console.log('you were logged in!');
        }
      },
    });
  },

  logout: function(e){
    e.preventDefault();
    var url = app.API + 'logout'
    $.ajax({
      url:url,
      type:'POST',
      dataType: 'json',
      success:function(data){
        console.log('you were logged out');
      },
    });
  }

}
});

;require.register("lib/view_helper", function(exports, require, module) {
// Put your handlebars.js helpers here.

Handlebars.registerHelper('pick', function(val, options) {
  return options.hash[val];
});

});

;require.register("models/collection", function(exports, require, module) {
// Base class for all collections.
module.exports = Backbone.Collection.extend({

  // fetch: function(options){
  //   // @desc custom fetch that redirects based on server error status

  //   // if there is an error method passed in as an option
  //   // run that error method.
  //   var originalError = options.error;
  //   // overwrite the error function passed in as a function
  //   options.error = function(collection, response, options){
  //     if (originalError){
  //       // run the original error method.
  //       originalError(collection, response, options);
  //     }
  //     // then redirect based on response status.
  //     if (response.status == 401){
  //       Backbone.history.navigate('login', true);
  //     }
  //     if (response.status == 403){
  //       Backbone.history.navigate('denied', true);
  //     }
  //   };
  //   // run original fetch method.
  //   Backbone.Collection.prototype.fetch.apply(this, arguments);
  // }
});

});

;require.register("models/model", function(exports, require, module) {
// Base class for all models.
module.exports = Backbone.Model.extend({

  // fetch: function(options){
  //   // @desc custom fetch that redirects based on server error status

  //   // if there is an error method passed in as an option
  //   // run that error method.
  //   var originalError = options.error;
  //   // overwrite the error function passed in as a function
  //   options.error = function(model, response, options){
  //     if (originalError){
  //       // run the original error method.
  //       originalError(model, response, options);
  //     }
  //     // then redirect based on response status.
  //     if (response.status == 401){
  //       Backbone.history.navigate('login', true);
  //     }
  //     if (response.status == 403){
  //       Backbone.history.navigate('denied', true);
  //     }
  //   };
  //   // run original fetch method.
  //   Backbone.Model.prototype.fetch.apply(this, arguments);
  // }

});
});

;require.register("models/user-collection", function(exports, require, module) {
var app = require('application');
var BaseCollection = require('models/collection');
var UserModel = require('models/user-model')
module.exports = BaseCollection.extend({
  // url: app.API + 'users',
  model: UserModel
});

});

;require.register("models/user-model", function(exports, require, module) {
// Base class for all models.
var BaseModel = require('models/model');
var app = require('application');
module.exports = BaseModel.extend({

  // urlRoot: function(){
  //   return app.API + 'users';
  // },

  // Validation 
  validation: {
    firstName: {
      required: true
    },
    lastName: {
      required: true
    },
    email: {
      required:true,
      pattern: 'email'
    },
    confirmEmail: {
      required:true,
      pattern: 'email'
    },
    password: {
      minLength: 8
    },
    repeatPassword: {
      equalTo: 'password',
      msg: 'The passwords do not match'
    },
    zipCode: {
      required:true,
      // US zip code regex
      pattern: /^\d{5}(?:[-\s]\d{4})?$/
    },
    birthday: {
      required:true,
      
    },
    termsOfUse: {
      acceptance: true
    }
  }
});

});

;require.register("models/user-session-model", function(exports, require, module) {
// Keeps track of the current user 
// whether they've logged in with facebook or twitter or through univision.
var app = require('application');
var UserModel = require('models/user-model');

module.exports = UserModel.extend({
  defaults: {
    loggedIn: false,
    userId: ''
  },

  initialize: function(){
    // Singleton user object, how is this a singleton? look this up.
    // Access or listen on this through any module with app.session.user

  },

  // url: app.API + '/auth',



});

});

;require.register("views/AppLayout", function(exports, require, module) {
var app = require('application');
var ModalRegion = require('views/modal-region-view');

module.exports = Backbone.Marionette.Layout.extend({
  template: 'views/templates/appLayout',
  
	el: 'body',

	regions: {
    content: '#fabmob_view-container',
    modal: ModalRegion
	}
});

});

;require.register("views/base-modal-view", function(exports, require, module) {


module.exports = Backbone.Marionette.ItemView.extend({
  // Properties
  // --------------------------------------------------------
  id: 'fabmob_base-modal-view',

  // Lifecycle 
  // --------------------------------------------------------
  initialize: function(){
  },

  onRender: function(){

  },


  // Events
  // --------------------------------------------------------


  // Methods
  // --------------------------------------------------------


});

});

;require.register("views/confirmation-view", function(exports, require, module) {
var ConfirmationTemplate = 'views/templates/confirmation';


module.exports = Backbone.Marionette.ItemView.extend({
  // Properties
  // --------------------------------------------------------
  id: 'login-view',
  template: ConfirmationTemplate,

  // Lifecycle 
  // --------------------------------------------------------
  initialize: function(){

  },

  onRender: function(){

  },


  // Events
  // --------------------------------------------------------


  // Methods
  // --------------------------------------------------------



});

});

;require.register("views/forgot-password", function(exports, require, module) {
var ForgotPasswordTemplate = require('views/templates/forgot-password');
var App = require('application');
var BaseModalView = require('views/base-modal-view');
var EmailSentTemplate = require('views/templates/modal-templates/email-sent')

module.exports = Backbone.Marionette.ItemView.extend ({
  // Lifecycle
  //-------------------------------------------------------------------------
  initialize: function(){
  },

  onRender: function(){
    // @todo
    // this is sloppy figure out another way to do this
    $('#content-container').addClass('hidden-header-banner-ad');


  },

  onClose: function(){
    $('#content-container').removeClass('hidden-header-banner-ad');

  },

  //Properties
  //-------------------------------------------------------------------------
  template: ForgotPasswordTemplate,

  // Events 
  //-------------------------------------------------------------------------
  events: {
    // this is a fake event
    'submit #js-forgot-password-form': 'submitForgotPasswordForm'
  },

  //Methods
  //-------------------------------------------------------------------------
  submitForgotPasswordForm: function(e){
    e.preventDefault();
    this.spawnSuccessModal();
  },
  spawnSuccessModal: function() {
    var emailSentView = new BaseModalView({template: EmailSentTemplate});
    App.layout.modal.show(emailSentView);
  }
});
});

;require.register("views/home-view", function(exports, require, module) {
var HomeTemplate = require('views/templates/home');

module.exports = Backbone.Marionette.ItemView.extend({
  // Properties
  // --------------------------------------------------------
  id: 'home-view',
	template: HomeTemplate,

  // Lifecycle 
  // --------------------------------------------------------

  // Events
  // --------------------------------------------------------

  // Methods
  // --------------------------------------------------------

});

});

;require.register("views/login-view", function(exports, require, module) {
var LoginTemplate = require('views/templates/login');
var UserSessionHelper = require('lib/user-session-helper');
module.exports = Backbone.Marionette.ItemView.extend({
  // Properties
  // --------------------------------------------------------
  id: 'login-view',
  template: LoginTemplate,

  // Lifecycle 
  // --------------------------------------------------------
  initialize: function(){
    console.log('hey login whats up?');
  },

  onRender: function(){
    // @todo
    // this is sloppy figure out another way to do this
    $('#content-container').addClass('hidden-header-banner-ad');
  },

  onClose: function(){
    $('#content-container').removeClass('hidden-header-banner-ad');
  },

  // Events
  // --------------------------------------------------------
  events: {
    'submit #js-login-form': 'login',
    'click #js-log-out': 'logout'
  },

  // Methods
  // --------------------------------------------------------
  login: function(e){
    UserSessionHelper.login(e);
  },

  logout: function(e){
    UserSessionHelper.logout(e);
  }

});

});

;require.register("views/modal-region-view", function(exports, require, module) {
module.exports = Backbone.Marionette.Region.extend({
  // this manages modal views.  calls modal hide and modal show when the view its handling 
  // shows/closes.
  // this el is in appLayout.hbs
  el: "#modal",
  constructor: function(){
    _.bindAll(this, 'getEl', 'showModal', 'hideModal');
    Backbone.Marionette.Region.prototype.constructor.apply(this, arguments);
    this.on("show", this.showModal, this);
  },

  getEl: function(selector){
    var $el = $(selector);
    $el.on("hidden", this.close);
    return $el;
  },

  showModal: function(view){
    view.on("close", this.hideModal, this);
    this.$el.modal('show');
  },

  hideModal: function(){
    this.$el.modal('hide');
  }
});
});

;require.register("views/processing-video-view", function(exports, require, module) {
var ProcessingVideoView = require('views/templates/processing-video');
// Required for FAKE FUNCTION MIMIC API VIDEO UPLOAD
var app = require('application');

module.exports = Backbone.Marionette.ItemView.extend({

  // Lifecycle 
  // --------------------------------------------------------
  initialize: function(){

  },

  onRender: function(){
    // FAKE FUNCTION MIMIC API VIDEO UPLOAD
    $(this.el).find("#fabmob-loader-progress-bar").animate({
        width: "100%",
      }, 3000, function() {
        app.router.navigate('video_upload_success',{trigger: true, replace: true});
      });

  },
  // Events
  // --------------------------------------------------------


  // Methods
  // --------------------------------------------------------

  // Properties
  // --------------------------------------------------------
  template: ProcessingVideoView
});

});

;require.register("views/review-view", function(exports, require, module) {
var ReviewTemplate = require('views/templates/review');


module.exports = Backbone.Marionette.ItemView.extend({

  // Lifecycle 
  // --------------------------------------------------------


  // Events
  // --------------------------------------------------------


  // Methods
  // --------------------------------------------------------

  // Properties
  // --------------------------------------------------------
  template: ReviewTemplate
});

});

;require.register("views/sign-up-view", function(exports, require, module) {
var SignUpTemplate = require('views/templates/sign-up');
var App = require('application');
var BaseModalView = require('views/base-modal-view');
var UserCollection = require('models/user-collection');

module.exports = Backbone.Marionette.ItemView.extend ({
  // Lifecycle
  //-------------------------------------------------------------------------
  initialize: function(){
    // this hooks up the validation for the form
    // Backbone.Validation.bind(this);
  },

  onRender: function(){
    // @todo
    // this is sloppy figure out another way to do this
    $('#content-container').addClass('hidden-header-banner-ad');

  },

  onClose: function(){
    // Backbone.Validation.unbind(this);
    $('#content-container').removeClass('hidden-header-banner-ad');
  },

  //Properties
  //-------------------------------------------------------------------------
  template: SignUpTemplate,

  // Events 
  //-------------------------------------------------------------------------
  events: {
    'submit form': 'signUp'
  },

  //Methods
  //-------------------------------------------------------------------------
  signUp: function(e){
    e.preventDefault();
    var formData = this.$el.find('form').serializeObject();
    this.model.set(formData);
    // Check if the model is valid before saving
    if(this.model.isValid(true)){
      this.model.save();

      // This is how you spawn a modal. 
      // you can make an entirely new view and pass it to modal.show
      // or you can just add another template to base-modal-view
      // and use the template by passing in an option.
      // var successDialogView = new BaseModalView({template: SuccessDialogTemplate});
      // App.layout.modal.show(successDialogView);
    } else {
      // var failureDialogView = new BaseModalView({template: FailureDialogTemplate});
      // App.layout.modal.show(failureDialogView);
    }
  }
});
});

;require.register("views/static-view", function(exports, require, module) {
module.exports = Backbone.Marionette.ItemView.extend({
  // Properties
  // --------------------------------------------------------
  id: 'fabmob_static-view',

  // Lifecycle 
  // --------------------------------------------------------
  initialize: function(){
  },

  onRender: function(){

  }


  // Events
  // --------------------------------------------------------


  // Methods
  // --------------------------------------------------------


});

});

;require.register("views/templates/appLayout", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  


  return "\n<div class=\"snap-drawers\">\n  <div class=\"snap-drawer snap-drawer-left\">\n    <ul id=\"nav\">\n      <li><a href=\"/#home\">Inicio</a></li>\n      <li><a href=\"/#upload\">Sube</a></li>\n      <li><a href=\"/#open_mic_auditions\">Open Mic Auditions</a></li>\n      <li><a href=\"/#how_to_audition\">How To Audition</a></li>\n      <li><a href=\"/#telemundo_terms_of_use\">Telemundo T&eacute;rminos de Uso</a></li>\n      <li><a href=\"/#telemundo_privacy_policy\">Telemundo Pol&iacute;tica de Privacidad</a></li>\n      <li><a href=\"/#youtoo_terms_of_use\">Youtoo T&eacute;rminos de Uso</a></li>\n      <li><a href=\"/#youtoo_privacy_policy\">Youtoo Pol&iacute;tica de Privacidad</a></li>\n      <li><a href=\"/#eligibility_requirements\">Eligibility Requirements</a></li>\n\n\n\n    </ul>\n    <a id=\"snap-drawer-login-btn\" class=\"btn fabmob_auth-flow-btn\" href=\"/#login\">\n      Empezar\n    </a>\n\n    <a id=\"snap-drawer-logout-btn\" class=\"btn fabmob_auth-flow-btn hidden\" href=\"/#\">\n      Cerrar la Sesi&oacute;n\n    </a>\n\n  </div>\n</div>\n\n<div id=\"content-container\" class=\"snap-content\">\n    <div id=\"toolbar\">\n        <a href=\"#\" id=\"open-left\"></a>\n    </div>\n    <div id=\"fabmob_banner\"></div>\n    <div id=\"fabmob_view-container\"></div>\n</div>\n\n\n<div class=\"modal fade\" id=\"modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">\n</div>\n";
  });
});

;require.register("views/templates/forgot-password", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  


  return "<div class=\"fabmob_content-container text-center\">\n  <form id=\"js-forgot-password-form\" role=\"form\" action=\"POST\">\n    <h2 id=\"fabmob_forgot-password-header\">Restablecer Contrase&#241;a</h2>\n    <div class=\"form-group\">\n      <input type=\"email\" class=\"form-control\" name=\"email\" placeholder=\"Direcci&#243;n de correo electr&#243;nico\">\n    </div>\n    <button id=\"js-forgot-password-btn\" type=\"submit\" class=\"btn btn-default btn-block btn-success btn-inverse\">Enviar</button>\n    <a id=\"fabmob_forgot-password-cancel-link\" href=\"/#home\">cancelar</a>\n  </form>\n</div>\n";
  });
});

;require.register("views/templates/home", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  


  return "<div class=\"fabmob_content-container text-center\">\n  <div class=\"text-center\">\n    <a id=\"fabmob_home-open-mic-link\" href=\"/#open_mic_auditions\">\n      <h5>\n        Click here for open Mic Auditions\n      </h5>\n    </a>\n    <div class=\"fabmob_video-img-container\">\n      <div class=\"fabmob_video-play-button\"></div>\n      <img src=\"images/video-placeholder.jpg\">\n    </div>\n  </div>\n  <h2 id=\"fabmob_home-header\" class=\"text-center\">Upload A Video!</h2>\n\n  <p id=\"fabmob_home-copy\" class=\"text-center\">\n    Univisi&oacute;n Deportes te invita a ser parte de nuestro documental, una historia de f&uacute;tbol, contada a trav&eacute;s de fan&aacute;ticos de todas partes del mundo. &iexcl; Regístrate YA! Sube uno o varios videos y se parte de un documental de la gente, para la gente.\n  </p>\n\n  <a class=\"btn btn-block btn-inverse\" href=\"/#upload\">Upload A Video</a>\n  <a id=\"fabmob_home-eligibility-link\" href=\"/#eligibility_requirements\">Eligibility Requirements</a>\n</div>";
  });
});

;require.register("views/templates/login", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  


  return "<div class=\"fabmob_content-container\">\n  <form id=\"js-login-form\" role=\"form\" action=\"POST\">\n    <h2 class=\"text-center\">Reg&iacute;strate</h2>\n    <div class=\"form-group\">\n      <input type=\"email\" class=\"form-control\" name=\"email\" placeholder=\"Direcci&#243;n de correo electr&#243;nico\">\n    </div>\n    <div id=\"fabmob_login-password-form-input\" class=\"form-group\">\n      <input type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"Contrase&#241;a\">\n    </div>\n    <div class=\"text-center\">\n      <a id=\"fabmob_login-forgot-password-link\" href=\"/#forgot_password\">&iquest;Olvidaste tu contrase&ntilde;a?</a>\n    </div>\n    <button id=\"js-login-btn\" type=\"submit\" class=\"btn btn-default btn-block btn-inverse\">Reg&iacute;strate</button>\n  </form>\n\n  <p id=\"fabmob_login-divider\">o</p>\n\n  <a id=\"fabmob_btn-facebook\" class=\"btn btn-block fabmob_btn-social\">\n    Reg&iacute;strate con Facebook\n  </a>\n\n  <p id=\"fabmob_login-register-copy\">\n    &iquest;Eres nuevo en Telemundo? \n  </p>\n  <a id=\"fabmob_login-register-link\" href=\"/#sign_up\">Reg&iacute;strate</a>\n</div>";
  });
});

;require.register("views/templates/modal-templates/email-sent", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  


  return "<div class=\"modal-dialog modal-sm\">\n  <div class=\"modal-content\">\n    <h3 class=\"modal-title text-center\" id=\"fabmob_modal-email-sent-header\">Gracias</h3>\n    <div class=\"modal-body\">\n      <p class=\"text-center\">\n        Pronto, te enviaremos instrucciones\n        para que cambies tu contrase&ntilde;a\n      </p>\n    </div>\n\n    <button type=\"button\" class=\"btn fabmob_btn-modal-dismiss\" data-dismiss=\"modal\">OK</button>\n\n  </div>\n</div>";
  });
});

;require.register("views/templates/processing-video", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  


  return "<div class=\"fabmob_content-container\">\n  <h3 class=\"text-center\">Gracias por esperar</h3>\n  <div id=\"fabmob_banner_large_rectangle\"></div>\n\n  <h2 class=\"text-center\">Estamos procesando tu video</h2>\n\n  <div id=\"fabmob-loader\">\n    <div id=\"fabmob-loader-progress-bar\"></div>\n  </div>\n  \n</div>";
  });
});

;require.register("views/templates/review", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "";


  buffer += "<div class=\"fabmob_content-container\">\n\n  <form id=\"fabmob_review-form\" class=\"form-horizontal\" role=\"form\">\n\n    <label>Titulo</label>\n    <input type=\"text\" placeholder=\"Titulo *Requerido\" class=\"form-control\" id=\"title\" name=\"title\" />\n    <span class=\"help-block hidden\"></span>\n\n    <label>Descripci&oacute;n</label>\n    <input type=\"text\" placeholder=\"Descripci&oacute;n *Opcional\" id=\"description\" class=\"fabmob-review-form-description-input form-control\" name=\"description\" />\n    <span class=\"help-block hidden\"></span>\n\n    <input type=\"checkbox\" value=\"true\" class=\"fabmob_review-form-terms-checkbox\"  />\n    <label class=\"fabmob_review-form-terms-checkbox-label\">\n      By checking, you agree lorem ipsum dolor sit amet, consectetur lorem ipsum dolor sit amet, consectutur adipisicing elit.\n    </label>\n    <span class=\"help-block hidden\"></span>\n\n\n    <input type=\"checkbox\" value=\"true\" class=\"fabmob_review-form-terms-checkbox\" name=\"originalContent\" />\n    <label class=\"fabmob_review-form-terms-checkbox-label\">\n      Placeholder text: User certifies that this submission is original content consectetur lorem ipsum dolor sit amet, consectutur adipisicing elit.\n    </label>\n    <span class=\"help-block hidden\"></span>\n\n\n    <h5 id=\"fabmob_review-form-friends-header\">Let your friends know</h5>\n\n    <input type=\"checkbox\" value=\"true\" />\n    <label>\n      Twitter\n    </label>\n    <span class=\"help-block hidden\"></span>\n\n    <input type=\"checkbox\" value=\"true\" />\n    <label>\n      Facebook\n    </label>\n    <span class=\"help-block hidden\"></span>\n\n\n    "
    + "\n\n    <a href=\"/#processing_video\" id=\"fabmob_review-form-submit-btn\" class=\"btn btn-block btn-inverse\">\n      Enviar\n    </a>\n\n    <div class=\"text-center\">\n      <a id=\"fabmob_review-form-upload-link\" href=\"/#upload\">Re-Upload</a>\n    </div>\n   "
    + "\n\n  </form>\n</div>";
  return buffer;
  });
});

;require.register("views/templates/sign-up", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  


  return "<div class=\"fabmob_content-container\">\n    <form class=\"form-horizontal fabmob_condensed-form\" role=\"form\">\n         <h3 class=\"text-center\">Comienza Aqui&iacute;</h3>\n        <div class=\"form-group\">\n            <input type=\"text\" placeholder=\"Nombre\" class=\"form-control fabmob_round-border-top\" id=\"first-name\" name=\"firstName\" />\n            <span class=\"help-block hidden\"></span>\n        </div>\n        <div class=\"form-group\">\n            <input type=\"text\" placeholder=\"Apellido\" class=\"form-control\" id=\"last-name\" name=\"lastName\" />\n            <span class=\"help-block hidden\"></span>\n        </div>\n        <div class=\"form-group\">\n            <input type=\"email\" placeholder=\"Direcci&#243;n de correo electr&#243;nico\" class=\"form-control\" id=\"email\" name=\"email\" />\n            <span class=\"help-block hidden\"></span>\n        </div>\n        <div class=\"form-group\">\n            <input type=\"email\" placeholder=\"Confirmar direcci&#243;n de correo electr&#243;nico\" class=\"form-control\" id=\"confirm-email\" name=\"confirmEmail\" />\n            <span class=\"help-block hidden\"></span>\n        </div>\n        <div class=\"form-group\">\n            <input type=\"password\" placeholder=\"Contrase&#241;a\" class=\"form-control\" id=\"password\" name=\"password\" />\n            <span class=\"help-block hidden\"></span>\n        </div>\n        <div class=\"form-group\">\n            <input type=\"password\" placeholder=\"Confirmar contrase&#241;a\" class=\"form-control\" id=\"repeat-password\" name=\"repeatPassword\" />\n            <span class=\"help-block hidden\"></span>\n        </div>\n        <div class=\"form-group\">\n            <input type=\"text\" placeholder=\"C&#243;digo postal/ZIP\" class=\"form-control\" id=\"zip-code\" name=\"zipCode\" />\n            <span class=\"help-block hidden\"></span>\n        </div>\n        <div class=\"form-group\">\n            <input id=\"fabmob_sign-up-date-input\" type=\"date\" placeholder=\"Fecha de nacimiento\" class=\"form-control fabmob_round-border-bottom\" id=\"birthday\" name=\"birthday\" />\n            <span class=\"help-block hidden\"></span>\n        </div>\n        <div class=\"form-group\">\n            <input id=\"fabmob_sign-up-terms-input\" type=\"checkbox\" value=\"true\" id=\"terms-of-use\" name=\"termsOfUse\" />\n            <span id=\"fabmob_sign-up-terms-input-label\">\n                Acepto los&nbsp;\n                <a href=\"/#terms_of_use\">\n                    T&eacute;rminos de Uso\n                </a> \n                &nbsp; &amp; &nbsp;\n                <a href=\"/#privacy_policy\">\n                    Pol&iacute;tica de privacidad\n                </a>\n                &nbsp;y la&nbsp;\n                <a href=\"/#rules_and_regulations\">\n                    Normas y Reglamentos\n                </a>\n            </span>\n\n            <span class=\"help-block hidden\"></span>\n        </div>\n\n        <button type=\"submit\" id=\"signUpButton\" class=\"btn btn-block btn-inverse\">Enviar</button>\n\n        <p id=\"fabmob_login-divider\">o</p>\n\n        <a id=\"fabmob_btn-facebook\" class=\"btn btn-block fabmob_btn-social\">\n          Reg&iacute;strate con Facebook\n        </a>\n\n    </form>\n</div>";
  });
});

;require.register("views/templates/static-view-templates/eligibility-requirements", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  


  return "<div class=\"fabmob_static-content-container\">\n  <h4>Eligibility Requirements</h4>\n  <p>\n    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum\n  </p>\n  <p>\n    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\n  </p>\n  <p>\n    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum\n  </p>\n  <p>\n    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\n  </p>\n</div>";
  });
});

;require.register("views/templates/static-view-templates/how-to-audition", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  


  return "<div class=\"fabmob_static-content-container\">\n  <h4>How To Audition</h4>\n  <p>\n    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum\n  </p>\n  <p>\n    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\n  </p>\n  <p>\n    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum\n  </p>\n  <p>\n    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\n  </p>\n</div>";
  });
});

;require.register("views/templates/static-view-templates/open-mic-auditions", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  


  return "<div class=\"fabmob_static-content-container\">\n  <h4>Step 1</h4>\n  <p>\n    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniamest laborum.\n  </p>\n  <h4>Step 2</h4>\n  <p>\n    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniamest laborum.\n  </p>\n  <h4>Step 3</h4>\n  <p>\n    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniamest laborum.\n  </p>\n  <a href=\"#\">Contact Us</a>\n</div>";
  });
});

;require.register("views/templates/static-view-templates/telemundo-privacy-policy", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  


  return "<div class=\"fabmob_static-content-container\">\n  <h4>Telemundo Pol&iacute;tica de Privacidad</h4>\n  <p>\n    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum\n  </p>\n  <p>\n    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\n  </p>\n  <p>\n    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum\n  </p>\n  <p>\n    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\n  </p>\n</div>";
  });
});

;require.register("views/templates/static-view-templates/telemundo-terms-of-use", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  


  return "<div class=\"fabmob_static-content-container\">\n  <h4>Telemundo T&eacute;rminos de Uso</h4>\n  <p>\n    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum\n  </p>\n  <p>\n    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\n  </p>\n  <p>\n    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum\n  </p>\n  <p>\n    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\n  </p>\n</div>";
  });
});

;require.register("views/templates/static-view-templates/youtoo-privacy-policy", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  


  return "<div class=\"fabmob_static-content-container\">\n  <h4>Youtoo Pol&iacute;tica de Privacidad</h4>\n  <p>\n    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum\n  </p>\n  <p>\n    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\n  </p>\n  <p>\n    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum\n  </p>\n  <p>\n    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\n  </p>\n</div>";
  });
});

;require.register("views/templates/static-view-templates/youtoo-terms-of-use", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  


  return "<div class=\"fabmob_static-content-container\">\n  <h4>Youtoo T&eacute;rminos de Uso</h4>\n  <p>\n    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum\n  </p>\n  <p>\n    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\n  </p>\n  <p>\n    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum\n  </p>\n  <p>\n    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\n  </p>\n</div>";
  });
});

;require.register("views/templates/topics", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  


  return "<div class=\"fabmob_content-container\">\n  <ul id=\"fabmob_topics\">\n    <li>\n      <div class=\"fabmob_topic-content\">\n        <a href=\"/#review\">\n          <h5 class=\"fabmob_topic-header\">1 Tema</h5>\n          <p>&iquest;Cu&aacute;l es tu primer recuerdo de un Mundial?</p>\n          <span class=\"fabmob_topic-arrow-btn\"></span>\n        </a>\n      </div>\n\n      <div class=\"fabmob_topic-content\">\n        <a href=\"/#review\">\n          <h5 class=\"fabmob_topic-header\">2 Tema</h5>\n          <p>\n            &iquest;Cu&aacute;l es el momento m&aacute;s feliz que te ha dejado un Mundial?\n          </p>\n          <span class=\"fabmob_topic-arrow-btn\"></span>\n        </a>\n      </div>\n\n      <div class=\"fabmob_topic-content\">\n        <a href=\"/#review\">\n          <h5 class=\"fabmob_topic-header\">3 Tema</h5>\n          <p>&iquest;Cu&aacute;l es el momento m&aacute;s triste que te ha dejado un Mundial?</p>\n          <span class=\"fabmob_topic-arrow-btn\"></span>\n        </a>\n      </div>\n\n      <div class=\"fabmob_topic-content\">\n        <a href=\"/#review\">\n          <h5 class=\"fabmob_topic-header\">4 Tema</h5>\n          <p>&iquest;Qu&eacute; es lo que m&aacute;s te gusta del Mundial?</p>\n          <span class=\"fabmob_topic-arrow-btn\"></span>\n        </a>\n      </div>\n\n      <div class=\"fabmob_topic-content\">\n        <a href=\"/#review\">\n          <h5 class=\"fabmob_topic-header\">5 Tema</h5>\n          <p>&iquest;Cu&aacute;l es el momento m&aacute;s memorable de los Mundiales?</p>\n          <span class=\"fabmob_topic-arrow-btn\"></span>\n        </a>\n      </div>\n      \n\n    </li>\n  </ul>\n\n</div>";
  });
});

;require.register("views/templates/video-upload-success", function(exports, require, module) {
module.exports = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  


  return "<div class=\"fabmob_content-container\">\n\n  <h2 id=\"fabmob_video-upload-success-header\">&iexcl;Felicidades!</h2>\n  <p id=\"fabmob_video-upload-success-copy\">\n    Your video has been submitted and will be approved shortly.  In the meantime, don't stop now!\n  </p>  \n\n</div>";
  });
});

;require.register("views/topics-view", function(exports, require, module) {
var TopicsTemplate = require('views/templates/topics');


module.exports = Backbone.Marionette.ItemView.extend({

  // Lifecycle 
  // --------------------------------------------------------


  // Events
  // --------------------------------------------------------


  // Methods
  // --------------------------------------------------------

  // Properties
  // --------------------------------------------------------
  template: TopicsTemplate
});

});

;require.register("views/video-upload-success-view", function(exports, require, module) {
var VideoUploadSucess = require('views/templates/video-upload-success');


module.exports = Backbone.Marionette.ItemView.extend({

  // Lifecycle 
  // --------------------------------------------------------


  // Events
  // --------------------------------------------------------


  // Methods
  // --------------------------------------------------------

  // Properties
  // --------------------------------------------------------
  template: VideoUploadSucess
});

});

;
//# sourceMappingURL=app.js.map
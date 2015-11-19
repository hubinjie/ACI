require.config({
	baseUrl: SITE_URL+'scripts/',
    paths: {
        "jquery": "./lib/jquery", 
        "jquery-ui": "./lib/jquery-ui-1.10.0.custom.min", 
		"jquery-ui-dialog-extend": "./lib/jquery-ui-dialog-extend", 
        "underscore": "./lib/underscore",
        "bootstrap": "./lib/bootstrap", 
		"validationEngine": "./lib/jquery.validationEngine", 
		"validationEngineLang": "./lib/jquery.validationEngine-zh_CN", 
		"bootstrapValidator": "./lib/bootstrapValidator", 
		"formValidation": "./lib/formValidation.min", 
		"aci":"./lib/aci",
		"message":"./lib/sco.message",
		"confirm":"./lib/sco.confirm",
		"modal":"./lib/sco.modal",
		"headroom":"./lib/headroom.min",
        "cookie":"./lib/jquery.cookie",
        "datetimepicker":"lib/jquery.datetimepicker"
    },
    shim: {
        "jquery-ui": {
            exports: "$",
            deps: ['jquery']
        },
        "datetimepicker": {
            exports: "$",
            deps: ['jquery']
        },
        "cookie": {
            exports: "$",
            deps: ['jquery']
        },
        "underscore": {
            exports: "_"
        },
        "bootstrapValidator": {
            exports: "$",
            deps: [ "jquery"]
        },
        "bootstrap": ['jquery'],
		"validationEngine": ['validationEngineLang'],
		"jquery-ui-dialog-extend": ['jquery-ui'],
		"aci": ['jquery'],
		"message": {
            exports: "$",
            deps: ['jquery']
        },
		"confirm": {
            exports: "$",
            deps: ['jquery']
        },
		"modal": {
            exports: "$",
            deps: ['jquery']
        },
		"headroom": {
            exports: "$",
            deps: ['jquery']
        },
    },
    waitSeconds: 0

});


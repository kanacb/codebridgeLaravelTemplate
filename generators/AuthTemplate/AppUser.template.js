const zzz= [
    {
        //AuthController
        location:"app/Http/Controllers/auth/",
        filename:"authController.php",
        templateLocalFile:"./cb/AuthTemplates/AuthController.template.js",
        changes:[
            {
                typeOfChange:"~cd-service-name~",  //string-replace
                from:"cb-service-name",
                to:"stack.serviceName",
            },
        ],
    },
    {
        //model
        location:"app/Models/",
        filename:"User.php",
        templateLocalFile:"./cb/AuthTemplates/Model.template.js",
        changes:[
            {
                typeOfChange:"~cb-service-name~", //string replace
                from:"cb-service-name",
                to:"cb-service-name",
            },
        ],

    },
    {
        //Email template
        location:"app/Providers/",
        filename:"AuthServiceProvider.php",
        templateLocalFile:"./cb/AuthTemplates/EmailTemplate.template.js",
        changes:[
            {
                typeOfChange:"~cb-service-name~", //string insert
                from:"",
                to:"",
            },
        ],

    },
    {
        //Event Handle
        location:"app/Providers/",
        filename:"EventServiceProvider.php",
        templateLocalFile:"./cb/AuthTemplates/EventHandle.template.js",
        changes:[
            {
                typeOfChange:"~cb-service-name~", //string replace
                from:"$listen",
                to:"",
            },
        ],

    },
    {
        //Mail route
        location:"routes/",
        filename:"web.php",
        templateLocalFile:"./cb/AuthTemplates/MailRoute.template.js",
        changes:[
            {
                typeOfChange:"~cb-service-name~", //string insert
                from:"",
                to:"",
            },
        ],

    },
    {
        //Mail api route
        location:"routes/",
        filename:"api.php",
        templateLocalFile:"./cb/AuthTemplates/UserAPI.template.js",
        changes:[
            {
                typeOfChange:"~cb-service-name~", //string insert
                from:"",
                to:"",
            },
        ],

    },



];
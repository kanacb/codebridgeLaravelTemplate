const zzz = [
    {
        //Migration file
        location:"database/migrations",
        filename:"~cd-service-name~Controller.php",
        templateLocalFile:"./cb/ServicesTemplates/Controller.template.js",
        changes:[
            {
                typeOfChange:"~cd-service-name~", //string-replace
                from:"cb-service-name",
                to:"stack.serviceName",
            },
            {
                typeOfChange:"cb-app-migration-field-up", //string-replace
                from:"cb-service-name",
                to:"service.fieldName",
            },
            {
                typeOfChange:"cb-app-migration-field-down", //string-replace
                from:"cb-service-name",
                to:"service.fieldName",
            },
        ],
    },
    {
        //Controller
        location:"app/Http/Controllers/",
        filename:"~cd-service-name~Controller.php",
        templateLocalFile:"./cb/ServicesTemplates/Controller.template.js",
        changes:[
            {
                typeOfChange:"~cd-service-name~", //string-replace
                from:"cb-service-name",
                to:"stack.serviceName",
            },
        ],
    },
    {
        //FakerFactorySample
        location:"database/factories/",
        filename:"~cd-service-name~Factory.php",
        templateLocalFile:"./cb/ServicesTemplates/Factory.template.js",
        changes:[
            {
                typeOfChange:"~cd-fakername~", //string-replace
                from:"cb-fakername",
                to:"stack.fakerName",
            },
            {
                typeOfChange:"~cd-fakerType~", //string-replace
                from:"cb-fakerType",
                to:"stack.fakerType",
            },
            {
                typeOfChange:"~cd-fakerCondition1~", //string-replace
                from:"cb-fakerCondition1",
                to:"stack.fakerCondition1",
            },
            {
                typeOfChange:"~cd-fakerCondition2~", //string-replace
                from:"cb-fakerCondition2",
                to:"stack.fakerCondition2",
            },
        
        ],
    },
    {
        //SeederModify
        location:"database/seeders/",
        filename:"~cd-service-name~Seeder.php",
        templateLocalFile:"./cb/ServicesTemplates/Seeder.template.js", //string-replace
        changes:[
            {
                typeOfChange:"~cd-fakerName~",
                from:"cb-fakerName",
                to:"stack.fakerName",
            },
            {
                typeOfChange:"~cd-seedTimes~",
                from:"cb-seedTimes",
                to:"stack.seedTimes",
            },
        ],
    },
    //CreateRepository
    {
        location: "App/Repository/",
        filename: "~cb~service~name~Repository.php",
        templateLocalFile: "./cb/ServicesTemplates/Repository.template.js", //string-replace
        changes: [
            {
                typeOfChange: "~cb-service-name~",
                from: "cb-service-name",
                to: "stack.serviceName",
            },
        ], 
    },
    //CreateRepositoryInterface
    {
        location: "App/Interfaces/",
        filename: "~cb~service~name~Interface.php",
        templateLocalFile: "./cb/ServicesTemplates/Interface.template.js", //string-replace
        changes: [
            {
                typeOfChange: "~cb-service-name~",
                from: "cb-service-name",
                to: "stack.serviceName",
            },
            ~cb-app-migration-servicename~
            ~cb-app-migration-field-up~
            ~cb-app-migration-field-down~
        ],    
    },
    {
        //Provider
        location:"app/Providers/",
        filename:"RepositoryServiceProvider.php",
        templateLocalFile:"./cb/ServicesTemplates/Provider.template.js",
        changes:[
            {
                typeOfChange:"~cd-service-name~", //string-replace
                from:"cb-service-name",
                to:"stack.serviceName",
            },
        ],
    },
    {
        //provider Service
        location:"config/",
        filename:"app.php",
        templateLocalFile:"./cb/ServicesTemplates/Service.template.js",
        changes:[
            {
                typeOfChange:"string-replace",
                from:"providers",
                to:"",
            },
        ],
    },
    {
        //Router
        location:"routes/",
        filename:"api.php",
        templateLocalFile:"./cb/ServicesTemplates/Route_API.template.js",
        changes:[
            {
                typeOfChange:"~cd-service-name~", //string-insert
                from:"cb-service-name",
                to:"stack.serviceName",
            },
        ],
    },
];

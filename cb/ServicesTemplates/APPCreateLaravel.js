const zzz = [
    {
        location: "",
        filename: ".env",
        changes: [
            {   // change database connection config
                typeOfChange: "string-replace",
                from: "DB_DATABASE=",
                to: "DB_DATABASE=stack.appName",
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
                typeOfChange:"~cd-service-name~", //string-replace
                from:"cb-service-name",
                to:"stack.serviceName",
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
                typeOfChange:"~cd-service-name~",
                from:"cb-service-name",
                to:"stack.serviceName",
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
        //RouteApi
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



    // TEST SCRIPTS // todo paid users only
    {
        templateLocalFile: "./react_prime/TestScripts/common/AreYouSureDialog.test.js", //
        location: "src/components/common/_test_/",
        filename: "AreYouSureDialog.test.js",
        changes: [],
    },
    // TEST SCRIPTS // todo paid users only
    {
        templateLocalFile: "./react_prime/TestScripts/common/EditSaveCancelComponent.test.js",
        location: "src/components/common/_test_/",
        filename: "EditSaveCancelComponent.test.js",
        changes: [],
    },
    // TEST SCRIPTS // todo paid users only
    {
        templateLocalFile: "./react_prime/TestScripts/Dashboard/Dashboard.test.js",
        location: "src/components/Dashboard/_test_/",
        filename: "Dashboard.test.js",
        changes: [],
    },
    // {
    //     templateLocalFile: "./react_prime/TestScripts/AreYouSureDialog.test.js",
    //     location: "src/components/common/_test_/",
    //     filename: "AreYouSureDialog.test.js",
    //     changes: [
    //         {
    //             typeOfChange: "string-replace",
    //             from: "cb-service-name-capitalize",
    //             to: "service.serviceName",
    //         },
    //         {
    //             typeOfChange: "string-replace",
    //             from: "cb-service-name",
    //             to: "service.serviceName",
    //         },
    //     ],
    //     renameFile: {
    //         from: "cb-service-name-capitalize",
    //         to: "service.serviceName",
    //     },
    // },
];
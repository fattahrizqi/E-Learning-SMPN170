# Note: Read it in Word Wrap

# E-Learning SMPN 170, build in Native PHP MVC architecture, using .htaccess rewriteEngine for URL rule

    ## Native PHP MVC (Model-View-Controller) application is a web application architecture that separates an application into three main components: the model, the view, and the controller.

        ### The model is responsible for managing data and providing it to the view. It is the component that interacts with the database and retrieves or stores data.

        ### The view is responsible for rendering the data provided by the model. It is the component that the user interacts with and sees on the screen.

        ### The controller is responsible for receiving and processing user input, calling the appropriate model and view components, and returning the appropriate response to the user.

    ## In a native PHP MVC application, the controller is implemented using PHP scripts, which listen to requests made by users and determine how to handle them. The model is implemented using PHP classes, which interact with the database and provide the data to the controller. The view is implemented using PHP templates, which generate the HTML code that is sent to the user's web browser.

    ## By using the MVC architecture, native PHP MVC applications are easier to maintain, test, and scale. The separation of concerns between the model, view, and controller components makes it easier to modify and update the application without affecting other components. Additionally, the use of PHP classes and templates promotes code reusability, reducing the time and effort needed to develop new features or fix bugs.

    ## Overall, using Native PHP MVC can result in more maintainable, scalable, and testable web applications, with a more efficient development process.

--------------------------------------------------------------------------------------------------------------

# Manual Book

    ## Make your local database in PhpMyAdmin etc. with dbname db_e-learning_smpn170, then import the table with sql file that available in App\database\

    ## Access App\config\config.php for set your own configuration, like its BASEURL (ex: i store this app in xampp\htdocs, then i should write the baseurl 'http://localhost/E-Learning-SMPN170/' which it represent where the app stored, and the name of its app folder) and all database configuration (such as dbname, host, user, password)

    ## Read the short documentation in the source code (if you need)

--------------------------------------------------------------------------------------------------------------

# App\helpers explanation

    ## It's helpers program that useful on specific purpose

    ## helpers component build separately from the main code for reusability code

    ## App\helpers list:

        ### Flasher : for set and return a flash message as user action feedback
        ### Handler : (for now) build for handle HTTP $_FILES request before store into repo and db
        ### Request : as HTTP Request Method validator, usually this helpers use when the method is just only for POST method
        ### Time : function to convert database timestamp into user-friendly time
        ### Unique : useful static method to generate unique code
        ### Validator : as a form input validator

--------------------------------------------------------------------------------------------------------------

# App\middlewares explanation

    ## It's program for authorizing user's role

    ## as a E-Learning App, role that's in list :

        ### Student : Joining class by unique code that sended by teacher, submit a class work and get mark from teacher. Can start post but as discussion post, and edit profil

        ### Teacher : Create a class, set a class work, and set students mark, and edit profil

        ### Admin : Manage user account (create account for teacher or students, and create user by importing csv or xlsx file)
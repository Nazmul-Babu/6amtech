assalamualaikum sir
from your assignment i completed

1. Advanced Eloquent Relationships
2. Complex API Development
3. Middleware and Security(without audit log)
4. Task Scheduling and Queues(completed larger csv file handle)
    <!-- project info  -->
    A.first of all i did the project in locaslhost and i remove all the files from git ignore so that not to need create any env file or others and add datbase with project you will find the database in project folder.
    create a database name 6amtect and upload the database.if necessary you can use DatabaseSeeder there i write code for dummy user and admin.
    <!-- User Controller  -->
    a.if you look at userController there i show how can we reduce injection
    <!-- Post Controller  -->
    in Post controller i did
    a.Post with tag
    b.comment with tag and nested Comment
    c.filter post by tag
    for those operations i write lots of relationship function in User, Comment and Tag model.
    <!-- Api controller  -->
    url : http://127.0.0.1:8000/api/login (post)
    require parameters
    email,password.
    i generate api_secret_key for checkinng login status and send it to the user and the api_secret_key will update every when anyone hit url.

//login_auth_check
i write a common function for user auth check .and i used the function wherever i need to auth check
//post with pagiantion search
url:http://127.0.0.1:8000/api/posts (post)
require parameters
user_id , api_secret_key
// send notification
url:http://127.0.0.1:8000/api/send-notification (post)
require parameters
user_id , api_secret_key
  <!-- Middleware and Security  -->
  i made 3  middleware 
  one is for user auth check
  one is for backend authc heck with role
  one is for ipcheck authc heck with role(i mentioned localhost ip in IpWhitelistMiddleware)

<!-- AdminController -->
role base operation for admin

<!-- OperatorController -->
role base operations for operator 
handle larger csv file 

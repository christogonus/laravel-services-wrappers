# Laravel Snippets & Wrappers Around Services

This REPO is to store in-house wrappers around services that are used for projects so that we can reference and use them in future projects where necessary. 

The warppers will be located in "app/Services". Dependencies like API keys will be stored in config('service_name'). 

### An Example: 
Wrapper for OpenAI services will be on ***app/Services/Openai.php*** class. The dependencies will be stored in ***config/openai.php***

It is free to use for the public. But our team might not be answering technical questions on this git.

## IMPORTANT
We strive to keep implementations as simple as they can be at all times, so the wrappers will only cover the specific need of an app it is made for, not necessarily all APIs of the services implemented.

We learned under mentorship of ***Jeffrey Way***, who is a great teacher and most conventions are how we think is best in the industry, but you are free to change things around to meet your need.

We will try to comment the codes as much as possible, but we are not liable for any misuse or errors you encounter.

Warm Regards.

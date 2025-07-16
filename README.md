# Agent Web App

So, what is an "agent web app"?
Well it's an amalgamation of several transactional services into a single website.

## Background

This app was made as a task for Pt. Crocodic's coding camp program "Kelas Industri".
Since I consider myself a backend developer, you should expect the frontend to be
a jumbled mess. Pardon me for that!

# Folder Structure

## Routes

The routes are all placed inside /routes in several files referenced by the index "web.php".
The files and their functions are as follows :

1. web.php
    the index of all routes. It only contains authentication routes, and several include() statements.
2. admin.php
    this file contains routes relating to administrator modules. You may access it's index at /master.
3. pages.php
    contains only GET routes to display all pages.
4. bus_ticket.php
    contains the routes for actions related to bus ticket.
5. bpjs.php
    contains the routes for actions related to bpjs.
6. film_ticket.php
    contains the routes for actions related to film ticket.
7. game_topup.php
    contains the routes for actions related to game and its topup.
8. power_topup.php
    contains the routes for actions related to electrical power token.

## Views

Essentially, there's only one role : user. But since there is data that I want to display to admin, I separate
the folder of their views. Views in this context meant a blade.php file. The folders inside /resources/views are :

### Root

It's exactly /resources/views. There's some views which I consider "public" for logged-in user and admin, which
I put at the root here. The files are
1. home.blade.php
2. report.blade.php
3. vouchers.blade.php

### Agent

the agent folder contains 5 subfolders belonging to each services.
These subfolders contains views necessary to make transaction on the
related service.

### Auth

the auth folder contains views used for logging in and registering.

### Components

the components folder contains views which is to be reused across
several different views through the use of @include().

### Master

the master folder contains several subfolders containing views required to
create, read, update, and delete the models required by the app's services to work.
The subfolders do not represent each service, rather they represent the model with which they
work with. All views here can and MUST be accessed from what is called a "resource controller"
which always contains template functions not to be explained here.

## Controllers

### Resources Controllers

contains controllers which represents a resource and only has index(), show(), edit(), update(), delete(),
and destroy() as their methods.

### Views Controllers

controllers which are accessed only by GET method and returning only views.

### Utilities Controllers

controllers containing functions mirror to the app's features. It provides an abstraction of the access to
resources and of the passing of data with redirection to views controllers.
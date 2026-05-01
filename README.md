
# Overview

This took a very long time. Although the feature is simple (A blog post) I purposefully wanted to dive into what I didn't know and ended up learning and experimenting with a few different technologies (Wordpress, Digital ocean, Caddy, php and GraphQL being the main ones).

It took a while, especially since I had minimal experience with CMS's before this, had rarely used caddy and no experience with php.

To understand everything I had to observe about 6+ tutorials and review 2 docs to complete everything (this including having to restart my wordpress instance, and having to completely change the architecture once I understood how limited I would be using just wordpress alone considering how many plugins require you to pay for a pro version).

It took a lot of time to set-up, but now I can work with a headless wordpress and make direct edits to the instance of wordpress I have through the functions.php file in my repo, and work with WPLocal in my developer environment to make changes that are good in representation before applying them to my actual wordpress instance.

Let's talk about how along with future considerations

# Hosting

## Where did you deploy it?

The website is currently being hosted within digital ocean on two droplets. 

The first droplet hosts a *wordpress* instance that is pulling it's code from my git repository [Click-labs-wordpress](https://github.com/Chilllnote/Click-labs-wordpress). It hosts itself within the domain **breezy-wordpress.duckdns.org**, the domain registered through duckdns

The second droplet hosts my *REACT* application, fully able to be composed with *Docker*. Its code comes from my git repository [Click-Labs-Breezy](https://github.com/Chilllnote/Click-Labs-Breezy).

Both can only be pushed to if you have the ssh key that both my machines and my local machine have. You cannot create edits otherwise (to ensure no unwanted changes can be made).

## Why did you choose that hosting provider?

Digital ocean gives you a bunch of free credits that you can use when you are first hosting your sites. This is also something you could gain from AWS.....but I really just didn't want to use those credits. 

I would say, launching this website through elastic beanstalk would be just as good an idea (more so actually) but digital ocean works just as well to get a machine spun up quickly and with reduced cost. You also get to have full ownership over the infrastructure of the droplet. The only thing after is that you have to set-up the machine directly to host the site (manipulating the caddy file, pulling from the main branch, writing a CRON script to do all of these on a given interval, etc) instead of having easy click uploads and pointing directly to the repository, having it run immediately. 

# CMS / Content Management

## If a non-technical marketing person needed to update the text and images on this site, how would they do it with your set-up?

I can give two ways of making this work

### *1. Adding in new posts to be made and defining their queries*

The way work within this headless wordpress architecture works right now is through co-operation between the developer and the "non-technical marketing person"

Dependent on what they would need to change, you can create the post type for them within functions.php. As of right now, the main post type is Blog Post.

With this defined, you would use ACF (Advanced Custom Fields) to then define the fields for the post. You would point a given custom field type to point to the new post type you've made so that each time they wish to make a new post, they would just fill in those fields. 

![ACF image](<Screenshot 2026-05-01 085738.png>)


If there is any different information we would wish to change on the website (for example: pricing and what each tier would contain) we would define them following this process.

Next, we would test the query within the Wordpress GraphQL plugin (it having a connecting plugin for ACF). With these queries tested, we just have to make the query within our front-end application to see them appear. Full process visible below:

*Creation of the Blog Post*
![Blog post page](<Screenshot 2026-05-01 090758.png>)


*Query set-up to get all blog posts*
![GraphQL query](<Screenshot 2026-05-01 090707.png>)


*How the query shows up within the website*
![Visual of Query](<Screenshot 2026-05-01 090826.png>)


All in all, a non-technical person with access to the wordpress admin window would only need to fill out the sections defined within ACF while adding a new post to get that post to show up within the website.

### *2. How would they update the site?*

Simple, they would just click "add new post" within the created post, fill out the form, and publish. They do not need to worry how it is rendered, just know that the query in GraphQL takes care of most of the issues and makes sure their work is seen without a hitch.

### *What would you change to make it easier?*

The process itself is pretty streamlined. If the person wanted to make a new template for a part of the site, I'd assume they'd ask the UI/UX designer to make a template and then the developer to implement the template,  do the queries and set-up the post type so that they can then make changes to that part of the site. It's a Headless architecture, the marketing person would not be making direct HTML changes without consulting the team.

# Security

## What security considerations did you account for?

First, no one can access the main repositories without the ssh keys added to those repositories. This way, no one can make direct changes to the website that are unwanted.

Second, the servers in which these websites are being hosted have to be ssh'd into for you to make those changes. Those keys I keep on my local device within an encrypted file.

Is this enough security? Eh.....I think there could be some extensions (based around possible features in the future)

### *Extensions to security*

- Sign-up security
	- Clerk authentication
		- Clerk is a library that does route-guarding for you almost out of the box. It also creates the login-page for you directly. If we were to have someone register as a breather (and they want that maximum gulp of air), making it so they can access their account and some locked off links through this could give both UI and security 
	- JWT
		- You could also set-up a regular authentication through JWT to make it so that the client has a session token. It's up to what the purpose of the application is to decide what type of authentication you wish to have
- Container security
	- AWS
		- AWS has a suite of tools for protecting its container. These types of options are available in digital ocean within limited capacity. Luckily, by isolating site data in persistent volumes and using containerized services, the stack can be seamlessly migrated to AWS. This unlocks enterprise-grade security tools like IAM for granular access control and CloudWatch for advanced system observability, definitely something to consider if you are making an enterprise level site.
- WP-admin access
	- Only defined IPs
		- A *big* extension of security is making it so that only certain IPs can even reach the login for wordpress. As of right now, there is full access to that page. However, I do not want that, as someone could get user and pass for the site and access them immediately. This would be my first extension
- Up-time security (more fault tolerance than security, but also a good consideration)
	- Kubernetes
		- Easiest and quickest way to ensure fault-tolerance is to get an instance of Kubernetes up and running that can be accessed within the droplet so you can monitor the containers. In fact, this would be the second thing I add as an extension considering it's important for user experience to make sure they always have a site to go back to.


# Code maintenance

### How would a developer pick up and maintain this codebase? What documentation, tooling, or patterns did you put in place?

As of right now, the codebase is fairly simple so any developer could come in and work on the site with enough knowledge of what they are looking at.

Routes are created through react-router-dom defined within the App.tsx.

The Pages each contain the components that make them up.

The layouts are outlets which create a given format for each page type.

And the components are the minimum parts that are rendered on each page.

There are also the utils which carries the toast from the original .html

All stylings are done through class .css within the index.css file. A port to Tailwind would be a good extension and make things a lot easier as you could then do inline styling.

The only process the developer would have to have (after having their device registered to the repository with the correct ssh key) is this:
- Develop locally within your given WPLocal instance and your dev instance of the frontend
- Push your changes to a given branch. After review, have this branch merge with main
- Either wait for the CRON job to pull from the main branch to your website, or ssh into the droplet and do the pull manually
- Within the droplet hosting wordpress, that's it. Within the droplet hosting the frontend, you must compose the services again.

There are additional extenstions I would wish to add though

### *Extensions*

- Powershell scripts
	- Within the droplets, there is a regular pattern of scripts that I would need to run to make sure my codebase is updated with a pull from main, that the container goes down, and that it rebuilds with the code it's meant to have within the respective services. These types of code runs could easily be automated with a quick script. With a CRON job, changes could be seen within each hour in fact.
- Docusaurus
	- This is a tech that allows me to have full control over how my documentation looks by manipulating the REACT script. It hosts my docs within a mini-server for me to direct people towards through a subdomain so they can understand how the codebase is meant to work.
	- (There are other, quicker tools....but this gives me a lot of control. Also, I like its name)

# Performance

## What did you do (or would you do) to optimize load times and performance?

There are many different ways to go about load times and performance. I'll break them down by the main categories I think should be focused on within this application considering what has been done and what could be done

- WPGraphQL
	- Caching
		- Using an object cache like Redis on the server to store resolved data and to stop doing repetitive hits to the database
	- Persisted queries
		- You can save a massive-lined GraphQL query within Wordpress as a consisted query and just send an ID (hash) for that given query. This reduces your upload requests.
- REACT
	- Query Batching
		- We are using the Apollo client, so we can batch multiple requests into a single HTTP request to avoid an unnecessary amount of hits to the backend. This also reduces HTTP overhead.
	- localStorage
		- You can store the results of queries within the localStorage of the client browser. It would make the website feel a lot more "instant" as well, since nothing is lost even on page refresh.
	- TanStack Query
		- A pretty well-known way to cache queries within REACT. Define a staleTime for how long the data is considered fresh and a gcTime for how long it stays in memory. You can also define when there is a refetch (such as doing a refetch when the user refocuses on the window).
# New Feature

## What feature did you add, 

I added an ability to create blog posts through wordpress. You can now login to wordpress through the associated link, login as an admin, and add posts to the website

## Why did you choose it,

The main focus was not to impress but to learn and show that learning quickly. I have only worked with wordpress for a small length of time and that was mainly to experiment with what it was. Within CMS's, I've used grapeJS, but I was able to just save entire user-made blogs through spring using the CMS and integrated it directly into the project. I did not learn how to do a proper rooted architecture with a CMS always being wished for.

For this, I wanted to make sure I learned how to launch a properly working website with a CMS as a core part of the architecture. I started with making just the wordpress site, then realized how little freedom I had to make decisions for the site and create its design. So I researched, and found that a headless wordpress architecture that uses GraphQL and ACF works best. 

## How does it work technically, 

It's simple. The wordpress site is hosted on the domain "Breezy-wordpress.duckdns.org". You can log into it's admin console with "Breezy-wordpress.duckdns.org/wp-admin". From there, you would go to Blog Post as the created post category type, and write a new post. 

The plugins that are set-up make it easy then to write a query that would work to get the information you wish within the GraphQL IDE. From there, you write the query directly in the front-facing website code, then you design how that query should look within visual studio. 

After making sure all changes in github were added, you will be able to see your REACT template design that gathers the queries from your wordpress site display them in the form you wish. You will see all the blog posts created within the Blog screen. On click, you will then query for the blog on their slug and go to a dynamic page that will show the blog post in its entirety.

## And what would you improve or extend if you had more time?

A good few things

- The styling is ok, but it could be improved
	- You could add a way to see the blog posts show up as you scroll smoothly
	- The blog itself is ok for showing the information, but I think you could stylize it better. 
	- If there are a lot of blog posts, you would have to scroll a long way. Having the latest blogs show up with a link to all blogs you can scroll through would be a great addition.
- A search functionality
	- A search for previous blog posts would be great as the post numbers grow
	- Another great thing would be a chatbot that can navigate the website to find what you are wishing for and even answer questions on what purchase works best and what blog would help you to understand why it works best.
- Comment section/rating
	- Having the ability for users (if they are registered breathers) to interact with blog posts and show satisfaction or dislike would help marketers to know what "functionality" added to their product (or announcements made) lead to them gaining praise or ire. Helpful for understand what Breezy should focus on next.

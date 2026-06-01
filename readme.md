# MSMoto Symfony Project

## Functionality: Client Side
This is a simple shop interface with: 

**Home Page** where we have a 
- Slider
- About Us Section
- Contact Us Section
- Our Products Section
- Our Services Section
- The Store Location Section

**Shop page** where we **list the products** and we have an option of **filtering the products** and **pagination** 

**Single Product Page** to display Product data.

## Functionality: Admin Panel
We have an authentication option with 1 user/admin and after logging in, redirection to Admin Dashboard where the Admin can Add, Modify, Delete Products, Brands, Product Categories, Product Features and also can modify website setting like font, colors etc.

## Used Stacks / Technologies
1. Symfony 7.4
2. PHP 8.3
3. Docker
4. MySQL
5. Twig
6. StimulusBundle - Symfony UX Components

## Project GIT Repository
https://github.com/marienahapetian/MS-Motorcycles

## Installation without Docker
1. **Initiate Symfony App**

`composer create-project symfony/skeleton:"^7.4" msmoto_project`

or 

`git clone https://github.com/marienahapetian/MS-Motorcycles`

2. **Start Symfony Server (in the project folder)**

`symfony server:start`

## Installation with Docker
1. **Clone the GIT repository**

`git clone https://github.com/marienahapetian/MS-Motorcycles`

2. **Build Docker Image (Dockerfile)**

`docker build -t symfony-app .`

3. **Start Docker Container with Environment Variables**

`docker run -d \
  --name symfony-app \
  --network web \
  -e APP_ENV=prod \
  -e APP_DEBUG=0 \
  -e APP_SECRET="Your secret here" \
  -e CLOUDINARY_URL="cloudinary url" \
  -e DATABASE_URL="mysql://dbuser:dbpass@mysql:3306/dbnale" \
  -e MESSENGER_TRANSPORT_DSN="doctrine://default?auto_setup=1" \
  -e DEFAULT_URI="your domain" \
  symfony-app`

  4. **Of course we will need a running SQL server, so with Docker we need to Download and Build MySQL image.**

  `docker pull mysql/mysql-server:tag`

  `docker run --name=mysql -d mysql/mysql-server:tag`

  To check Database we connect by

  `docker exec -it mysql mysql -u root -p`

  5. **To create the tables we create and run the migrations**

  `docker exec -it symfony-app bash -c "php bin/console doctrine:migrations:diff"`

`docker exec -it symfony-app bash -c "php bin/console doctrine:migrations:migrate --no-interaction"`

## URLs

- / - Home Page
- /shop - display products to clients, Shop Page
- /{productId-productSlug} - display a single product with details
- /login - login page for Admin
- /dashboard
- /dashboard/products - list of products
- /dashboard/product/add - add a product
- /dashboard/product/edit/{productId} - modify a product
- /dashboard/categories - list product categories
- /dashboard/categories/add - add a category
- /dashboard/categories/edit/{categoryId} - edit a category
- /dashboard/brands - list product brands
- /dashboard/brands/add - add a brand
- /dashboard/brands/edit/{brandId} - modify a brand
- /dashboard/features - list product features
- /dashboard/features/add - add a feature
- /dashboard/features/edit/{featureId} - edit a feature
- /dashboard/messages - list messages from Contact Us Form
- /dashboard/message/{messageId} - view the message

## Authors

- Mari Nahapetyan
https://github.com/marienahapetian




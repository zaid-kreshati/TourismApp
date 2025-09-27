# Travelova - Tourism Management System

Travelova is a comprehensive tourism management system that allows users to effortlessly book airline tickets, hotel reservations, and rent cars. The application is built using the Laravel framework, providing a powerful and scalable backend for managing the system's functionality.

## Features

- **User Authentication:** Users can register and log in to the application, enabling them to access personalized features and manage their reservations securely.

- **Destination Search:** Users can search for their desired travel destinations, making it easy to find the perfect location for their next trip.

- **Favorite Destinations:** Users can add destinations to their favorites list, allowing them to quickly access and refer to their preferred locations.

- **Hotel Booking:** Users can browse and book hotel rooms by selecting their preferred dates and location. The application offers a wide range of options to accommodate different preferences and budgets.

- **Car Rental:** Users can rent cars through the application by selecting the type of vehicle and desired rental period. This feature provides convenience and flexibility for users' transportation needs.

- **Country Information:** The application provides detailed information about various countries, including attractions, local customs, and travel tips. Users can explore and gather insights to make informed decisions when planning their trips.

- **Flight Booking:** Users can view available flights and book tickets by providing the necessary flight details. The application streamlines the booking process and allows users to manage their flight reservations efficiently.

- **Email Notifications:** The application sends email notifications to users for various events. Users receive emails when they add a destination to their favorites, book a hotel, rent a car, or book a flight. These notifications keep users informed about their travel activities.

## Technologies Used

- **Backend Framework:** Laravel
- **API Development:** Laravel API Resources
- **Database:** MySQL
- **API Testing:** Postman
- **Backend Libraries:** Laravel Livewire, Jetstream, Breeze
- **Additional Libraries:** Sweet Alert

## Getting Started

To set up the Travelova Tourism Management System locally, follow these steps:

1. Clone the project repository from GitHub.
2. Install the necessary dependencies for the Laravel backend using Composer.
3. Set up a MySQL database and update the database configuration in the `.env` file.
4. Run the database migrations to create the required tables:

   ````shell
   php artisan migrate
   
Passport Error
php artisan passport:install
 Kyes Generate
php artisan migrate:fresh
php artisan passport:client - - personal


multi Auth : Link : https://www.nicesnippets.com/blog/laravel-8-multi-authentication-api-tutorial


5. Seed the database with initial data:

   ````shell
   php artisan db:seed
   

6. Start the Laravel development server:

   ````shell
   php artisan serve
   

7. Import the provided Postman collection (`postman.postman_collection.json`) into Postman.
8. Configure the environment variables in Postman to match your local setup.
9. You can now use the Postman collection to explore and test the API endpoints.


## Conclusion

Travelova is a powerful tourism management system that simplifies the process of booking flights, hotels, and rental cars. With its robust backend built on Laravel and user-friendly API, it provides a seamless experience for both users and administrators. Whether you're planning a leisure trip or business travel, Travelova has the features you need to make your journey smooth and enjoyable.

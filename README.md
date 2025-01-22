# Project Setup Instructions

Follow these steps to set up the project on another computer:

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd <repository-directory>
   ```

2. **Install PHP dependencies using Composer**:
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies using npm**:
   ```bash
   npm install
   ```

4. **Copy the `.env.example` file to `.env`**:
   ```bash
   cp .env.example .env
   ```

5. **Generate the application key**:
   ```bash
   php artisan key:generate
   ```

6. **Set up the database**:
    - Update the `.env` file with your database credentials.
    - Run the migrations to create the database tables:
      ```bash
      php artisan migrate
      ```

7. **Build the front-end assets**:
   ```bash
   npm run dev
   ```

8. **Start the development server**:
   ```bash
   php artisan serve
   ```

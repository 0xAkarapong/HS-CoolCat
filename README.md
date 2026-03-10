# CoolCat

CoolCat is a premier community platform for connecting loving homes with feline friends, alongside a dedicated shop for premium cat supplies.

## Features

- **Cat Adoption Marketplace**: Browse and adopt cats from a variety of breeds.
- **Premium Supplies Shop**: A curated selection of high-quality cat products.
- **User Dashboard**: Manage your inquiries, orders, and profile.
- **Reactive UI**: Built with Livewire for a smooth, single-page-app feel.
- **Modern Design**: Styled with Tailwind CSS and Flux UI components.

## Tech Stack

- **Framework**: [Laravel 12](https://laravel.com)
- **Frontend**: [Livewire 4](https://livewire.laravel.com) with [Volt](https://livewire.laravel.com/docs/volt)
- **UI Components**: [Flux UI](https://fluxui.dev)
- **Authentication**: [Laravel Fortify](https://laravel.com/docs/fortify)
- **Styling**: [Tailwind CSS](https://tailwindcss.com)
- **Asset Bundling**: [Vite](https://vitejs.dev)
- **Package Manager**: [Composer](https://getcomposer.org) (PHP) & [Bun](https://bun.sh) (JS)
- **Testing**: [Pest](https://pestphp.com)

## Getting Started

### Prerequisites

- PHP 8.5+
- Bun
- Composer
- SQLite (or your preferred database)

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/0xAkarapong/coolcat.git
   cd HS-CoolCat/CoolCat
   ```

2. Run the setup script:
   ```bash
   composer run setup
   ```
   *This will install dependencies, create your `.env` file, generate an app key, and run migrations.*

3. Start the development server:
   ```bash
   composer run dev
   ```

## Development

- **Run Tests**: `php artisan test`
- **Lint Code**: `composer run lint`
- **Build Assets**: `bun run build`
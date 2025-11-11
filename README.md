# Mini PHP Framework

> Minimal PHP MVC framework running with Docker.

## ⚠️ Prerequisites

You **must have Docker installed** on your machine to work with this framework.
You can download it here: [https://www.docker.com/get-started]

## 🚀 Quick Start

### 1. Clone the repository

```bash
git clone https://github.com/arsenavetisyan987/mini-framework.git

cd mini-framework

make start-build   # First time setup or when Dockerfiles change
make down          # Stop the app
make start         # Restart without rebuilding
make down-v        # Full clean up (removes all data)




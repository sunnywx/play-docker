# SQLite Docker Setup

This directory contains a complete Docker setup for playing with SQLite in different ways.

## What's Included

1. **SQLite CLI Container** - Direct command-line access to SQLite
2. **SQLite Web Interface** - Browser-based database management
3. **Python Development Environment** - For scripting and data analysis

## Quick Start

### 1. Build and Start All Services

```bash
cd sqlite
docker compose up -d
```

### 2. Create Sample Database

```bash
# Run the sample database creation script
docker compose exec sqlite-python python create_sample_db.py
```

### 3. Access SQLite in Different Ways

#### Option A: Command Line Interface
```bash
# Access SQLite CLI
docker compose exec sqlite-cli sqlite3 example.db

# Example commands in SQLite CLI:
# .tables                    # List all tables
# .schema users              # Show table schema
# SELECT * FROM users;       # Query data
# .quit                      # Exit
```

#### Option B: Web Interface
1. Make sure the sqlite-web service is running
2. Open your browser and go to: http://localhost:8080
3. You'll see a web interface to browse and query your database

#### Option C: Python Environment
```bash
# Access Python container
docker compose exec sqlite-python python

# Or run example scripts:
docker compose exec sqlite-python python query_examples.py
```

## File Structure

```
sqlite/
├── docker compose.yml          # Main orchestration file
├── Dockerfile.sqlite-web       # Web interface container
├── Dockerfile.python          # Python development container
├── data/                      # Database files (persistent)
│   └── example.db            # Sample database (created by script)
├── scripts/                  # Python scripts
│   ├── create_sample_db.py   # Creates sample database
│   └── query_examples.py     # Example queries
└── README.md                 # This file
```

### Working with SQLite CLI
```bash
# Connect to database
docker compose exec sqlite-cli sqlite3 /data/example.db

# Import SQL file
docker compose exec sqlite-cli sqlite3 /data/example.db < /scripts/your_script.sql

# Export database
docker compose exec sqlite-cli sqlite3 /data/example.db .dump > backup.sql
```

### Python Development
```bash
# Interactive Python session
docker compose exec sqlite-python python

# Run a specific script
docker compose exec sqlite-python python your_script.py

# Install additional packages
docker compose exec sqlite-python pip install package_name
```

## Sample Database Schema

The example database includes:

- **users** table: id, name, email, age, created_at
- **posts** table: id, user_id, title, content, created_at

## Tips

1. **Data Persistence**: The `./data` directory is mounted as a volume, so your databases persist between container restarts
2. **Scripts**: Put your Python scripts in the `./scripts` directory to access them from containers
3. **Web Interface**: The sqlite-web interface is great for quick data exploration and visualization
4. **CLI Power**: Use the SQLite CLI for advanced operations and scripting

## Troubleshooting

- If port 8080 is already in use, change it in docker compose.yml
- Make sure Docker and Docker Compose are installed
- Check container logs with `docker compose logs [service-name]`

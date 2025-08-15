#!/usr/bin/env python3
"""
Sample script to create and populate a SQLite database
"""

import sqlite3
import os

def create_sample_database():
    # Connect to database (creates it if it doesn't exist)
    db_path = '/data/example.db'
    conn = sqlite3.connect(db_path)
    cursor = conn.cursor()
    
    # Create tables
    cursor.execute('''
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            age INTEGER,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ''')
    
    cursor.execute('''
        CREATE TABLE IF NOT EXISTS posts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            title TEXT NOT NULL,
            content TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users (id)
        )
    ''')
    
    # Insert sample data
    users_data = [
        ('Alice Johnson', 'alice@example.com', 28),
        ('Bob Smith', 'bob@example.com', 34),
        ('Charlie Brown', 'charlie@example.com', 22),
        ('Diana Prince', 'diana@example.com', 30)
    ]
    
    cursor.executemany(
        'INSERT OR IGNORE INTO users (name, email, age) VALUES (?, ?, ?)',
        users_data
    )
    
    posts_data = [
        (1, 'Getting Started with SQLite', 'SQLite is a great embedded database...'),
        (1, 'Docker Tips', 'Here are some useful Docker commands...'),
        (2, 'Python Best Practices', 'Writing clean Python code is important...'),
        (3, 'Web Development', 'Modern web development involves many tools...'),
        (4, 'Database Design', 'Good database design is crucial for performance...')
    ]
    
    cursor.executemany(
        'INSERT OR IGNORE INTO posts (user_id, title, content) VALUES (?, ?, ?)',
        posts_data
    )
    
    # Commit changes and close
    conn.commit()
    conn.close()
    
    print(f"Sample database created at {db_path}")
    print("Tables: users, posts")
    print("Sample data inserted successfully!")

if __name__ == "__main__":
    create_sample_database()

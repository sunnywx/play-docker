#!/usr/bin/env python3
"""
Example queries for the SQLite database
"""

import sqlite3

def run_example_queries():
    conn = sqlite3.connect('/data/example.db')
    cursor = conn.cursor()
    
    print("=== SQLite Query Examples ===\n")
    
    # Query 1: All users
    print("1. All users:")
    cursor.execute("SELECT * FROM users")
    for row in cursor.fetchall():
        print(f"  ID: {row[0]}, Name: {row[1]}, Email: {row[2]}, Age: {row[3]}")
    
    print("\n" + "="*50 + "\n")
    
    # Query 2: Users with their post counts
    print("2. Users with post counts:")
    cursor.execute('''
        SELECT u.name, u.email, COUNT(p.id) as post_count
        FROM users u
        LEFT JOIN posts p ON u.id = p.user_id
        GROUP BY u.id, u.name, u.email
        ORDER BY post_count DESC
    ''')
    for row in cursor.fetchall():
        print(f"  {row[0]} ({row[1]}): {row[2]} posts")
    
    print("\n" + "="*50 + "\n")
    
    # Query 3: Recent posts with user names
    print("3. All posts with user names:")
    cursor.execute('''
        SELECT u.name, p.title, p.content, p.created_at
        FROM posts p
        JOIN users u ON p.user_id = u.id
        ORDER BY p.created_at DESC
    ''')
    for row in cursor.fetchall():
        print(f"  Author: {row[0]}")
        print(f"  Title: {row[1]}")
        print(f"  Content: {row[2][:50]}...")
        print(f"  Created: {row[3]}\n")
    
    conn.close()

if __name__ == "__main__":
    run_example_queries()

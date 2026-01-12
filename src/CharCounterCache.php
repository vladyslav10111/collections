# PHP String Unique Characters Counter

Simple PHP application that accepts a string via HTML form, checks if this string was already processed using cache (file cache or Redis), and returns the number of unique characters.

If the string exists in cache, the result is returned from cache.  
If not, the application calculates the number of unique characters, returns the result, and saves it to cache.

---

## Features

- HTML form input
- Cache check before processing
- File-based cache or Redis cache
- Counts unique characters in a string
- Avoids recalculation for repeated input

---

## How It Works

1. User submits a string via form
2. Application generates a cache key based on the input string
3. Cache is checked:
   - If found → return cached result
   - If not found → calculate unique characters
4. Result is returned and saved to cache
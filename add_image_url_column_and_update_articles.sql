-- Add image_url column to articles table
ALTER TABLE articles ADD COLUMN image_url VARCHAR(500);

-- Update articles with image URLs
UPDATE articles SET image_url = 'assets/hammer.png' WHERE title = 'Hammer';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Screwdriver' WHERE title = 'Screwdriver';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Tape+Measure' WHERE title = 'Tape Measure';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Level' WHERE title = 'Level';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Utility+Knife' WHERE title = 'Utility Knife';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Handsaw' WHERE title = 'Handsaw';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Circular+Saw' WHERE title = 'Circular Saw';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Drill' WHERE title = 'Drill';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Chisel' WHERE title = 'Chisel';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Wrench' WHERE title = 'Wrench (Spanner)';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Pliers' WHERE title = 'Pliers';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Nail+Gun' WHERE title = 'Nail Gun';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Ladder' WHERE title = 'Ladder';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Wheelbarrow' WHERE title = 'Wheelbarrow';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Trowel' WHERE title = 'Trowel';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Concrete+Mixer' WHERE title = 'Concrete Mixer';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Sledgehammer' WHERE title = 'Sledgehammer';
UPDATE articles SET image_url = 'https://via.placeholder.com/300x200?text=Stud+Finder' WHERE title = 'Stud Finder';
    
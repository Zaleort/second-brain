CREATE TABLE memories (
    id           UUID PRIMARY KEY,
    user_id      UUID NOT NULL,
    title        VARCHAR(255) NOT NULL,
    content      TEXT,
    type         INTEGER NOT NULL,
    created_at   TIMESTAMP NOT NULL DEFAULT now(),
    updated_at   TIMESTAMP
);

CREATE TABLE tags (
    id      UUID PRIMARY KEY,
    name    VARCHAR(255) NOT NULL,
    user_id UUID NOT NULL,
    color   VARCHAR(255)
);

CREATE TABLE memory_tags (
    memory_id UUID NOT NULL,
    tag_id    UUID NOT NULL,
    PRIMARY KEY (memory_id, tag_id),
    CONSTRAINT fk_memory
      FOREIGN KEY (memory_id)
      REFERENCES memories(id)
      ON DELETE CASCADE,
    CONSTRAINT fk_tag
      FOREIGN KEY (tag_id)
      REFERENCES tags(id)
      ON DELETE CASCADE
);

CREATE INDEX idx_memories_user_id  ON memories(user_id);
CREATE INDEX idx_tags_user_id      ON tags(user_id);
CREATE INDEX idx_memory_tags_tag   ON memory_tags(tag_id);
CREATE INDEX idx_memory_tags_memory ON memory_tags(memory_id);
package com.zaleort.second_brain.Memories.Infrastructure.Repository

import com.zaleort.second_brain.Tags.Infrastructure.Repository.TagEntity
import jakarta.persistence.*
import java.time.Instant
import java.util.*

@Entity(name = "memories")
class MemoryEntity(
    @Id
    var id: UUID? = null,

    @Column(name = "user_id", nullable = false)
    var userId: UUID? = null,
    @Column(name = "title")
    var title: String,
    @Column(name = "content")
    var content: String,
    @Column(name = "type")
    var type: Int,
    @Column(name = "created_at")
    var createdAt: Instant,
    @Column(name = "updated_at")
    var updatedAt: Instant? = null,

    @ManyToMany(cascade = [CascadeType.PERSIST, CascadeType.MERGE], targetEntity = TagEntity::class)
    @JoinTable(
        name = "memory_tags",
        joinColumns = [jakarta.persistence.JoinColumn(name = "memory_id")],
        inverseJoinColumns = [jakarta.persistence.JoinColumn(name = "tag_id")]
    )
    var tags: List<TagEntity> = emptyList()
) {
    constructor() : this(
        id = null,
        userId = null,
        title = "",
        content = "",
        type = 1,
        tags = emptyList(),
        createdAt = Instant.now(),
        updatedAt = null
    )
}

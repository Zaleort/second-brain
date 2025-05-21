package com.zaleort.second_brain.Memories.Infrastructure.Repository

import com.zaleort.second_brain.Tags.Infrastructure.Repository.TagEntity
import jakarta.persistence.CascadeType
import jakarta.persistence.Column
import jakarta.persistence.Entity
import jakarta.persistence.GeneratedValue
import jakarta.persistence.GenerationType
import jakarta.persistence.Id
import jakarta.persistence.JoinTable
import jakarta.persistence.ManyToMany
import java.time.Instant
import java.util.UUID

@Entity(name = "memories")
class MemoryEntity(
    @Id
    @GeneratedValue(strategy = GenerationType.UUID)
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

package com.zaleort.second_brain.Tags.Infrastructure.Repository

import com.zaleort.second_brain.Memories.Infrastructure.Repository.MemoryEntity
import jakarta.persistence.Column
import jakarta.persistence.Entity
import jakarta.persistence.GeneratedValue
import jakarta.persistence.GenerationType
import jakarta.persistence.Id
import jakarta.persistence.ManyToMany
import java.util.UUID

@Entity(name = "tags")
class TagEntity(
    @Id
    @GeneratedValue(strategy = GenerationType.UUID)
    var id: UUID? = null,

    @Column(name = "user_id", nullable = false)
    var userId: UUID? = null,

    @Column(name = "name", nullable = false, unique = true)
    var name: String,

    @Column(name = "color")
    var color: String? = null,

    @ManyToMany(mappedBy = "tags", targetEntity = MemoryEntity::class)
    var memories: List<MemoryEntity> = emptyList()
) {
    constructor() : this(
        id = null,
        userId = null,
        name = "",
        color = null,
        memories = emptyList()
    )
}
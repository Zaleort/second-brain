package com.zaleort.second_brain.Memories.Domain.Memory

import com.zaleort.second_brain.Users.Domain.User.UserId
import java.time.LocalDateTime

class Memory private constructor(
    val id: MemoryId,
    val userId: UserId,
    var title: MemoryTitle,
    var content: MemoryContent,
    var type: MemoryType,
    var tags: List<MemoryTag>,
    val createdAt: LocalDateTime,
    var updatedAt: LocalDateTime?,
) {
    fun update(
        title: MemoryTitle,
        content: MemoryContent,
        type: MemoryType,
        tags: List<MemoryTag>,
    ) {
        this.title = title
        this.content = content
        this.type = type
        this.tags = tags
        this.updatedAt = LocalDateTime.now()
    }

    companion object {
        fun create(
            id: MemoryId,
            userId: UserId,
            title: MemoryTitle,
            content: MemoryContent,
            type: MemoryType,
            tags: List<MemoryTag>,
        ): Memory {
            return Memory(
                id = id,
                userId = userId,
                title = title,
                content = content,
                type = type,
                tags = tags,
                createdAt = LocalDateTime.now(),
                updatedAt = null
            )
        }

        fun fromPrimitives(
            id: String,
            userId: String,
            title: String,
            content: String,
            type: Int,
            tags: List<Map<String, String?>>,
            createdAt: String,
            updatedAt: String?,
        ): Memory {
            return Memory(
                id = MemoryId(id),
                userId = UserId(userId),
                title = MemoryTitle(title),
                content = MemoryContent(content),
                type = MemoryType(type),
                tags = tags.map {
                    MemoryTag(
                        it["id"] ?: "",
                        it["name"] ?: "",
                        it["color"] ?: "",
                    )
                },
                createdAt = LocalDateTime.parse(createdAt),
                updatedAt = updatedAt?.let { LocalDateTime.parse(it) }
            )
        }
    }
}
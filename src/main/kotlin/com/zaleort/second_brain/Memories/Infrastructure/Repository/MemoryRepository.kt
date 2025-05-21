package com.zaleort.second_brain.Memories.Infrastructure.Repository

import com.zaleort.second_brain.Memories.Domain.Memory.Memory
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryId
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryRepositoryInterface
import com.zaleort.second_brain.Tags.Infrastructure.Repository.TagEntity
import com.zaleort.second_brain.Users.Domain.User.UserId
import org.springframework.stereotype.Repository
import java.time.ZoneOffset
import java.time.format.DateTimeFormatter
import java.util.UUID

@Repository
class MemoryRepository(
    private val memoryJpaRepository: JpaMemoryRepository,
) : MemoryRepositoryInterface {
    override fun findById(id: MemoryId): Memory? {
        val memoryEntity = memoryJpaRepository.findById(id.value).orElse(null)
        val tags: List<Map<String, String?>> = memoryEntity.tags.map { tag ->
            mapOf(
                "id" to tag.id.toString(),
                "name" to tag.name,
                "color" to tag.color,
            )
        }

        return memoryEntity?.let {
            Memory.fromPrimitives(
                id = it.id.toString(),
                userId = it.userId.toString(),
                title = it.title,
                content = it.content,
                type = it.type,
                tags = tags,
                createdAt = DateTimeFormatter.ISO_INSTANT.format(it.createdAt),
                updatedAt = it.updatedAt?.let { updatedAt -> DateTimeFormatter.ISO_INSTANT.format(updatedAt) },
            )
        }
    }

    override fun findByUserId(userId: UserId): List<Memory> {
        val memoryEntities = memoryJpaRepository.findByUserId(userId.toUUID())
return memoryEntities.map {
            val tags: List<Map<String, String?>> = it.tags.map { tag ->
                mapOf(
                    "id" to tag.id.toString(),
                    "name" to tag.name,
                    "color" to tag.color,
                )
            }
            Memory.fromPrimitives(
                id = it.id.toString(),
                userId = it.userId.toString(),
                title = it.title,
                content = it.content,
                type = it.type,
                tags = tags,
                createdAt = DateTimeFormatter.ISO_INSTANT.format(it.createdAt),
                updatedAt = it.updatedAt?.let { updatedAt -> DateTimeFormatter.ISO_INSTANT.format(updatedAt) },
            )
        }
    }

    override fun save(memory: Memory) {
        val entityTags = memory.tags.map { TagEntity(
            id = UUID.fromString(it.id),
            userId = memory.userId.toUUID(),
            name = it.name,
            color = it.color,
        ) }

        val memoryEntity = MemoryEntity(
            id = memory.id.toUUID(),
            userId = memory.userId.toUUID(),
            title = memory.title.value,
            content = memory.content.value,
            type = memory.type.value,
            tags = entityTags,
            createdAt = memory.createdAt.toInstant(ZoneOffset.UTC),
            updatedAt = memory.updatedAt?.toInstant(ZoneOffset.UTC),
        )

        memoryJpaRepository.save(memoryEntity)
    }

    override fun deleteById(id: MemoryId) {
        val memoryEntity = memoryJpaRepository.findById(id.value).orElse(null)
        if (memoryEntity == null) {
            throw Exception("Memory not found: " + id.value)
        }

        memoryJpaRepository.delete(memoryEntity)
    }

    override fun findAll(): List<Memory> {
        return memoryJpaRepository.findAll().map {
            val tags: List<Map<String, String?>> = it.tags.map { tag ->
                mapOf(
                    "id" to tag.id.toString(),
                    "name" to tag.name,
                    "color" to tag.color,
                )
            }
            Memory.fromPrimitives(
                id = it.id.toString(),
                userId = it.userId.toString(),
                title = it.title,
                content = it.content,
                type = it.type,
                tags = tags,
                createdAt = DateTimeFormatter.ISO_INSTANT.format(it.createdAt),
                updatedAt = it.updatedAt?.let { updatedAt -> DateTimeFormatter.ISO_INSTANT.format(updatedAt) },
            )
        }
    }
}
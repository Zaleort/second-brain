package com.zaleort.second_brain.Memories.Infrastructure.Repository

import com.zaleort.second_brain.Memories.Domain.Memory.Memory
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryId
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryRepositoryInterface
import com.zaleort.second_brain.Memories.Domain.Memory.MemorySearchParams
import com.zaleort.second_brain.Shared.Domain.QueryFilter.OrderDirection
import com.zaleort.second_brain.Shared.Domain.QueryFilter.PaginatedResult
import com.zaleort.second_brain.Tags.Infrastructure.Repository.JpaTagRepository
import com.zaleort.second_brain.Tags.Infrastructure.Repository.TagEntity
import com.zaleort.second_brain.Users.Domain.User.UserId
import jakarta.persistence.criteria.Predicate
import org.springframework.data.domain.PageRequest
import org.springframework.data.domain.Sort
import org.springframework.data.jpa.domain.Specification
import org.springframework.stereotype.Repository
import java.time.Instant
import java.time.ZoneOffset
import java.time.format.DateTimeFormatter
import java.util.*

@Repository
class MemoryRepository(
    private val memoryJpaRepository: JpaMemoryRepository,
    private val tagJpaRepository: JpaTagRepository,
) : MemoryRepositoryInterface {
    override fun findById(id: MemoryId): Memory? {
        val memoryEntity = memoryJpaRepository.findById(id.toUUID()).orElse(null)
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
        val entityTags = memory.tags.map {
            tagJpaRepository.getReferenceById(UUID.fromString(it.id))
        }

        val existing = memoryJpaRepository.findById(memory.id.toUUID())
        val memoryEntity = if (existing.isPresent) {
            val existingMemory = existing.get()
            existingMemory.title = memory.title.value
            existingMemory.content = memory.content.value
            existingMemory.type = memory.type.value
            existingMemory.tags = entityTags
            existingMemory.updatedAt = Instant.now()
            existingMemory
        } else {
            MemoryEntity(
                id = memory.id.toUUID(),
                userId = memory.userId.toUUID(),
                title = memory.title.value,
                content = memory.content.value,
                type = memory.type.value,
                tags = entityTags,
                createdAt = memory.createdAt.toInstant(ZoneOffset.UTC),
                updatedAt = memory.updatedAt?.toInstant(ZoneOffset.UTC),
            )
        }

        memoryJpaRepository.save(memoryEntity)
    }

    override fun deleteById(id: MemoryId) {
        val memoryEntity = memoryJpaRepository.findById(id.toUUID()).orElse(null)
        if (memoryEntity == null) {
            throw Exception("Memory not found: " + id.value)
        }

        memoryJpaRepository.delete(memoryEntity)
    }

    override fun search(params: MemorySearchParams): PaginatedResult<Memory> {
        val spec = buildSpecification(params)
        val sort = Sort.by(
            if (params.orderDirection == OrderDirection.ASC.value)
                Sort.Direction.ASC else Sort.Direction.DESC,
            params.orderBy
        )

        val pageable = PageRequest.of(params.page, params.limit, sort)
        val result = memoryJpaRepository.findAll(spec, pageable)

        val memories = result.content.map { memoryEntity ->
            val tags: List<Map<String, String?>> = memoryEntity.tags.map { tag ->
                mapOf(
                    "id" to tag.id.toString(),
                    "name" to tag.name,
                    "color" to tag.color,
                )
            }
            Memory.fromPrimitives(
                id = memoryEntity.id.toString(),
                userId = memoryEntity.userId.toString(),
                title = memoryEntity.title,
                content = memoryEntity.content,
                type = memoryEntity.type,
                tags = tags,
                createdAt = DateTimeFormatter.ISO_INSTANT.format(memoryEntity.createdAt),
                updatedAt = memoryEntity.updatedAt?.let { updatedAt -> DateTimeFormatter.ISO_INSTANT.format(updatedAt) },
            )
        }

        return PaginatedResult(
            items = memories,
            total = result.totalElements,
            page = params.page,
            limit = params.limit
        )
    }

    private fun buildSpecification(params: MemorySearchParams): Specification<MemoryEntity> {
        return Specification { root, _, cb ->
            val predicates = mutableListOf<Predicate>()

            params.userId?.let {
                predicates.add(cb.equal(root.get<UUID>("userId"), UUID.fromString(it)))
            }

            params.title?.let {
                predicates.add(cb.like(cb.lower(root.get<String>("title")), "%${it.lowercase()}%"))
            }

            params.content?.let {
                predicates.add(cb.like(cb.lower(root.get<String>("content")), "%${it.lowercase()}%"))
            }

            params.type?.let {
                predicates.add(cb.equal(root.get<Int>("type"), it))
            }

            params.tags?.let { tags ->
                val tagJoin = root.join<MemoryEntity, TagEntity>("tags")
                predicates.add(tagJoin.get<String>("id").`in`(tags))
            }

            params.createdAtFrom?.let {
                val date = Instant.parse(it).atZone(ZoneOffset.UTC).toInstant()
                predicates.add(cb.greaterThanOrEqualTo(root.get("createdAt"), date))
            }

            params.createdAtTo?.let {
                val date = Instant.parse(it).atZone(ZoneOffset.UTC).toInstant()
                predicates.add(cb.lessThanOrEqualTo(root.get("createdAt"), date))
            }

            cb.and(*predicates.toTypedArray())
        }
    }
}
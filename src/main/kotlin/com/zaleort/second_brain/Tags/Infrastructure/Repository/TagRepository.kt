package com.zaleort.second_brain.Tags.Infrastructure.Repository

import com.zaleort.second_brain.Shared.Domain.QueryFilter.OrderDirection
import com.zaleort.second_brain.Shared.Domain.QueryFilter.PaginatedResult
import com.zaleort.second_brain.Tags.Domain.Tag.Tag
import com.zaleort.second_brain.Tags.Domain.Tag.TagId
import com.zaleort.second_brain.Tags.Domain.Tag.TagRepositoryInterface
import com.zaleort.second_brain.Tags.Domain.Tag.TagSearchParams
import com.zaleort.second_brain.Users.Domain.User.UserId
import jakarta.persistence.criteria.Predicate
import org.springframework.data.domain.PageRequest
import org.springframework.data.domain.Sort
import org.springframework.data.jpa.domain.Specification
import org.springframework.stereotype.Repository
import java.util.*

@Repository
class TagRepository(
    private val jpaTagRepository: JpaTagRepository,
): TagRepositoryInterface {
    override fun findById(tagId: TagId): Tag? {
        val entity = jpaTagRepository.findById(tagId.toUUID()).orElse(null)
        if (entity == null) {
            return null
        }
        return Tag.fromPrimitives(
            id = entity.id.toString(),
            userId = entity.userId.toString(),
            name = entity.name,
            color = entity.color,
        )
    }

    override fun findByUserId(userId: UserId): List<Tag> {
        val tags = jpaTagRepository.findByUserId(userId.toUUID())
        return tags.map {
            Tag.fromPrimitives(
                id = it.id.toString(),
                userId = it.userId.toString(),
                name = it.name,
                color = it.color,
            )
        }
    }

    override fun save(tag: Tag) {
        val tagEntity = TagEntity(
            id = tag.id.toUUID(),
            userId = tag.userId.toUUID(),
            name = tag.name.value,
            color = tag.color?.value,
        )

        jpaTagRepository.save(tagEntity)
    }

    override fun delete(tagId: TagId) {
        val tagEntity = jpaTagRepository.findById(tagId.toUUID()).orElse(null)
        if (tagEntity == null) {
            throw Exception("Tag not found: " + tagId.value)
        }

        jpaTagRepository.delete(tagEntity)
    }

    override fun search(params: TagSearchParams): PaginatedResult<Tag> {
        val spec = buildSpecification(params)
        val sort = Sort.by(
            if (params.orderDirection == OrderDirection.ASC.value)
                Sort.Direction.ASC else Sort.Direction.DESC,
            params.orderBy
        )

        val pageable = PageRequest.of(params.page, params.limit, sort)
        val result = jpaTagRepository.findAll(spec, pageable)

        val tags = result.content.map { tagEntity ->
            Tag.fromPrimitives(
                id = tagEntity.id.toString(),
                userId = tagEntity.userId.toString(),
                name = tagEntity.name,
                color = tagEntity.color,
            )
        }

        return PaginatedResult(
            items = tags,
            total = result.totalElements,
            page = params.page,
            limit = params.limit
        )
    }

    private fun buildSpecification(params: TagSearchParams): Specification<TagEntity> {
        return Specification { root, _, cb ->
            val predicates = mutableListOf<Predicate>()

            params.userId?.let {
                predicates.add(cb.equal(root.get<UUID>("userId"), UUID.fromString(it)))
            }

            params.name?.let {
                predicates.add(cb.like(cb.lower(root.get<String>("name")), "%${it.lowercase()}%"))
            }

            cb.and(*predicates.toTypedArray())
        }
    }
}
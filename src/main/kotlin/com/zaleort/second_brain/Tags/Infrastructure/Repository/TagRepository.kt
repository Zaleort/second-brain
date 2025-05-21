package com.zaleort.second_brain.Tags.Infrastructure.Repository

import com.zaleort.second_brain.Tags.Domain.Tag.Tag
import com.zaleort.second_brain.Tags.Domain.Tag.TagId
import com.zaleort.second_brain.Tags.Domain.Tag.TagRepositoryInterface
import com.zaleort.second_brain.Users.Domain.User.UserId
import org.springframework.stereotype.Repository

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
}
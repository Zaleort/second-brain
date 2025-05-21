package com.zaleort.second_brain.Tags.Application.UseCases.UpdateTag

import com.zaleort.second_brain.Tags.Application.UseCases.TagDTO
import com.zaleort.second_brain.Tags.Domain.Tag.Exceptions.TagNotFoundException
import com.zaleort.second_brain.Tags.Domain.Tag.TagColor
import com.zaleort.second_brain.Tags.Domain.Tag.TagId
import com.zaleort.second_brain.Tags.Domain.Tag.TagName
import com.zaleort.second_brain.Tags.Domain.Tag.TagRepositoryInterface
import org.springframework.stereotype.Service

@Service
class UpdateTagHandler(
    private val tagRepository: TagRepositoryInterface,
) {
    fun execute(command: UpdateTagCommand): TagDTO {
        val tag = tagRepository.findById(TagId(command.id))
            ?: throw TagNotFoundException("Tag not found: " + command.id)

        if (tag.userId.value != command.userId) {
            throw TagNotFoundException("Tag not found: " + command.id)
        }

        tag.update(
            name = TagName(command.name),
            color = command.color?.let { TagColor(it) },
        )

        tagRepository.save(tag)
        return TagDTO.fromTag(tag)
    }
}
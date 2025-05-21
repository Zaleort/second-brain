package com.zaleort.second_brain.Tags.Application.UseCases.GetTag

import com.zaleort.second_brain.Tags.Application.UseCases.TagDTO
import com.zaleort.second_brain.Tags.Domain.Tag.Exceptions.TagNotFoundException
import com.zaleort.second_brain.Tags.Domain.Tag.TagId
import com.zaleort.second_brain.Tags.Domain.Tag.TagRepositoryInterface
import org.springframework.stereotype.Service

@Service
class GetTagHandler(
    private val tagRepository: TagRepositoryInterface,
) {
    fun execute(command: GetTagCommand): TagDTO {
        val tag = tagRepository.findById(TagId(command.id))
        if (tag == null) {
            throw TagNotFoundException("Tag not found: " + command.id)
        }

        if (tag.userId.value != command.userId) {
            throw TagNotFoundException("Tag not found: " + command.id)
        }

        return TagDTO.fromTag(tag)
    }
}
package com.zaleort.second_brain.Tags.Application.UseCases.DeleteTag

import com.zaleort.second_brain.Tags.Domain.Tag.Exceptions.TagNotFoundException
import com.zaleort.second_brain.Tags.Domain.Tag.TagId
import com.zaleort.second_brain.Tags.Domain.Tag.TagRepositoryInterface
import org.springframework.stereotype.Service

@Service
class DeleteTagHandler(
    private val tagRepository: TagRepositoryInterface,
) {
    fun execute(command: DeleteTagCommand) {
        val tag = tagRepository.findById(TagId(command.id))
            ?: throw TagNotFoundException("Tag not found: " + command.id)

        if (command.userId != tag.userId.value) {
            throw TagNotFoundException("Tag not found: " + command.id)
        }

        tagRepository.delete(tag.id)
    }
}
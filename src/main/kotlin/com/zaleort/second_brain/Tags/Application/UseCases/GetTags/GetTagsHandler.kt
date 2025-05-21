package com.zaleort.second_brain.Tags.Application.UseCases.GetTags

import com.zaleort.second_brain.Tags.Application.UseCases.TagDTO
import com.zaleort.second_brain.Tags.Domain.Tag.TagRepositoryInterface
import com.zaleort.second_brain.Users.Domain.User.UserId
import org.springframework.stereotype.Service

@Service
class GetTagsHandler(
    private val tagRepository: TagRepositoryInterface,
) {
    fun execute(command: GetTagsCommand): List<TagDTO> {
        val tags = tagRepository.findByUserId(UserId(command.userId))
        return tags.map { TagDTO.fromTag(it) }
    }
}
package com.zaleort.second_brain.Tags.Application.UseCases.GetTags

import com.zaleort.second_brain.Shared.Domain.QueryFilter.PaginatedResult
import com.zaleort.second_brain.Tags.Application.UseCases.TagDTO
import com.zaleort.second_brain.Tags.Domain.Tag.TagRepositoryInterface
import com.zaleort.second_brain.Tags.Domain.Tag.TagSearchParams
import org.springframework.stereotype.Service

@Service
class GetTagsHandler(
    private val tagRepository: TagRepositoryInterface,
) {
    fun execute(command: GetTagsCommand): PaginatedResult<TagDTO> {
        val tags = tagRepository.search(
            TagSearchParams(
                page = command.page,
                limit = command.limit,
                orderBy = command.orderBy,
                orderDirection = command.orderDirection,
                userId = command.userId,
                name = command.name,
            )
        )

        return PaginatedResult(
            items = tags.items.map { TagDTO.fromTag(it) },
            total = tags.total,
            page = tags.page,
            limit = tags.limit
        )
    }
}
package com.zaleort.second_brain.Tags.Infrastructure.Controllers

import com.zaleort.second_brain.Shared.Domain.QueryFilter.PaginatedResult
import com.zaleort.second_brain.Tags.Application.UseCases.GetTags.GetTagsCommand
import com.zaleort.second_brain.Tags.Application.UseCases.GetTags.GetTagsHandler
import com.zaleort.second_brain.Tags.Application.UseCases.TagDTO
import org.springframework.http.HttpStatus
import org.springframework.http.ResponseEntity
import org.springframework.security.core.annotation.AuthenticationPrincipal
import org.springframework.security.core.userdetails.UserDetails
import org.springframework.web.bind.annotation.GetMapping
import org.springframework.web.bind.annotation.RequestParam
import org.springframework.web.bind.annotation.RestController

@RestController
class GetTagsController(
    private val handler: GetTagsHandler,
) {
    @GetMapping("/api/v1/tags")
    fun getTags(
        @AuthenticationPrincipal user: UserDetails,
        @RequestParam(required = false) page: Int,
        @RequestParam(required = false) limit: Int,
        @RequestParam(required = false) orderBy: String,
        @RequestParam(required = false) orderDirection: String,
        @RequestParam(required = false) name: String,
    ): ResponseEntity<PaginatedResult<TagDTO>> {
        val userId = user.username
        val tags = handler.execute(
            GetTagsCommand(
                page = page,
                limit = limit,
                orderBy = orderBy,
                orderDirection = orderDirection,
                userId = userId,
                name = name
            )
        )

        return ResponseEntity(tags, HttpStatus.OK)
    }
}
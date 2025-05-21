package com.zaleort.second_brain.Tags.Infrastructure.Controllers

import com.zaleort.second_brain.Tags.Application.UseCases.GetTags.GetTagsCommand
import com.zaleort.second_brain.Tags.Application.UseCases.GetTags.GetTagsHandler
import com.zaleort.second_brain.Tags.Application.UseCases.TagDTO
import org.springframework.http.HttpStatus
import org.springframework.http.ResponseEntity
import org.springframework.security.core.annotation.AuthenticationPrincipal
import org.springframework.security.core.userdetails.UserDetails
import org.springframework.web.bind.annotation.GetMapping
import org.springframework.web.bind.annotation.RestController

@RestController
class GetTagsController(
    private val handler: GetTagsHandler,
) {
    @GetMapping("/api/v1/tags")
    fun getTags(
        @AuthenticationPrincipal user: UserDetails,
    ): ResponseEntity<List<TagDTO>> {
        val userId = user.username
        val tags = handler.execute(GetTagsCommand(userId))
        return ResponseEntity(tags, HttpStatus.OK)
    }
}
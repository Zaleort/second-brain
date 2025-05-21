package com.zaleort.second_brain.Tags.Infrastructure.Controllers

import com.zaleort.second_brain.Tags.Application.UseCases.GetTag.GetTagCommand
import com.zaleort.second_brain.Tags.Application.UseCases.GetTag.GetTagHandler
import com.zaleort.second_brain.Tags.Application.UseCases.TagDTO
import org.springframework.http.HttpStatus
import org.springframework.http.ResponseEntity
import org.springframework.security.core.annotation.AuthenticationPrincipal
import org.springframework.security.core.userdetails.UserDetails
import org.springframework.web.bind.annotation.GetMapping
import org.springframework.web.bind.annotation.PathVariable
import org.springframework.web.bind.annotation.RestController

@RestController
class GetTagController(
    private val handler: GetTagHandler,
) {
    @GetMapping("/api/v1/tags/{id}")
    fun getTag(
        @AuthenticationPrincipal user: UserDetails,
        @PathVariable id: String,
    ): ResponseEntity<TagDTO> {
        val userId = user.username
        val tag = handler.execute(GetTagCommand(id, userId))
        return ResponseEntity(tag, HttpStatus.OK)
    }
}
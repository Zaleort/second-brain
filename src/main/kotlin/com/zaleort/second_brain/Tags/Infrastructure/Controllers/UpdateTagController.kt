package com.zaleort.second_brain.Tags.Infrastructure.Controllers

import com.zaleort.second_brain.Tags.Application.UseCases.TagDTO
import com.zaleort.second_brain.Tags.Application.UseCases.UpdateTag.UpdateTagCommand
import com.zaleort.second_brain.Tags.Application.UseCases.UpdateTag.UpdateTagHandler
import org.springframework.http.HttpStatus
import org.springframework.http.ResponseEntity
import org.springframework.security.core.annotation.AuthenticationPrincipal
import org.springframework.security.core.userdetails.UserDetails
import org.springframework.web.bind.annotation.PathVariable
import org.springframework.web.bind.annotation.PutMapping
import org.springframework.web.bind.annotation.RequestBody
import org.springframework.web.bind.annotation.RestController

@RestController
class UpdateTagController(
    private val handler: UpdateTagHandler,
) {
    @PutMapping("/api/v1/tags/{id}")
    fun updateTag(
        @PathVariable id: String,
        @RequestBody command: UpdateTagCommand,
        @AuthenticationPrincipal user: UserDetails,
    ): ResponseEntity<TagDTO> {
        val userId = user.username
        val response = handler.execute(command.copy(
            id = id,
            userId = userId,
        ))

        return ResponseEntity(response, HttpStatus.OK)
    }
}
package com.zaleort.second_brain.Tags.Infrastructure.Controllers

import com.zaleort.second_brain.Tags.Application.UseCases.DeleteTag.DeleteTagCommand
import com.zaleort.second_brain.Tags.Application.UseCases.DeleteTag.DeleteTagHandler
import org.springframework.http.HttpStatus
import org.springframework.http.ResponseEntity
import org.springframework.security.core.annotation.AuthenticationPrincipal
import org.springframework.security.core.userdetails.UserDetails
import org.springframework.web.bind.annotation.DeleteMapping
import org.springframework.web.bind.annotation.PathVariable
import org.springframework.web.bind.annotation.RestController

@RestController
class DeleteTagController(
    private val handler: DeleteTagHandler,
) {
    @DeleteMapping("/api/v1/tags/{id}")
    fun deleteTag(
        @PathVariable id: String,
        @AuthenticationPrincipal user: UserDetails,
    ): ResponseEntity<Void> {
        val userId = user.username
        handler.execute(DeleteTagCommand(id, userId))
        return ResponseEntity(HttpStatus.NO_CONTENT)
    }
}
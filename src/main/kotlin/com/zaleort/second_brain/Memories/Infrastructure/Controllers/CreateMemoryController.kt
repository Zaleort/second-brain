package com.zaleort.second_brain.Memories.Infrastructure.Controllers

import com.zaleort.second_brain.Memories.Application.UseCases.CreateMemory.CreateMemoryCommand
import com.zaleort.second_brain.Memories.Application.UseCases.CreateMemory.CreateMemoryHandler
import com.zaleort.second_brain.Memories.Application.UseCases.MemoryDTO
import org.springframework.http.ResponseEntity
import org.springframework.security.core.annotation.AuthenticationPrincipal
import org.springframework.security.core.userdetails.UserDetails
import org.springframework.web.bind.annotation.PostMapping
import org.springframework.web.bind.annotation.RequestBody
import org.springframework.web.bind.annotation.RestController

@RestController
class CreateMemoryController(val handler: CreateMemoryHandler) {
    @PostMapping("/api/v1/memories")
    fun createMemory(
        @AuthenticationPrincipal user: UserDetails,
        @RequestBody request: CreateMemoryRequest
    ): ResponseEntity<MemoryDTO> {
        val command = CreateMemoryCommand(
            title = request.title,
            content = request.content,
            type = request.type,
            tags = request.tags,
            userId = user.username
        )

        return ResponseEntity(
            handler.execute(command),
            org.springframework.http.HttpStatus.CREATED,
        )
    }
}

data class CreateMemoryRequest(
    val title: String,
    val content: String,
    val type: Int,
    val tags: List<String>,
)